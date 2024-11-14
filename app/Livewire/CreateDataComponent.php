<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Data;
use App\Models\User;
use App\Models\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class CreateDataComponent extends Component
{
    use WithFileUploads;

    public $editMode = false;

    public $modelId, $bereich, $ueberschrift, $inhalt, $schlagworte, $berechtigung, $userid;
    public $benutzer;
    public $auswahlBereich;
    public $auswahlUsers;
    public $inputfiles;
    public $files = [];
    public $link;
    public $data;

    protected $rules = [
        'bereich' => 'required|max:80',
        'ueberschrift' => 'required|max:80',
        'inhalt' => 'required',
        'schlagworte' => 'required|max:255',

        'inputfiles.*' => 'mimes:jpg,png,pdf,gif|max:2048',
    ];

    public function mount($pid = null)
    {


        Log::info('Mount CreateDataComponent ID', [$pid, $this->id()]);

        $this->auswahlBereich = Data::distinct()->pluck('bereich');
        $this->auswahlUsers = User::select('id', 'name')->get();
        if ($pid){
            try {
                $this->modelId = $pid;
                $this->authorizeAccess(); // Neue Methode zur Berechtigungsprüfung
                $this->loadData();        // Neue Methode zum Laden der Daten
            } catch (\Exception $e) {
                Log::info('Fehler:', [$e]);
                return redirect()->route('home');
            }
        }
        else
            $this->resetInputFields();
    }

    protected function authorizeAccess()
    {
        $data = Data::find($this->modelId);
        if (!$data || ($data->berechtigung === 1 && $data->userid != Auth::id())) {
            Log::info('Keine Berechtigung');
            throw new \Exception('Sie haben keine Berechtigung!');
        }
    }

    public function loadData()
    {
//        Log::info('load ID: ', [$this->modelId]);
        if ($this->modelId) {
            $this->data = Data::find($this->modelId);
            if ($this->data) {

                // Log::info("set data");
                $this->modelId = $this->data->id;
                $this->bereich = $this->data->bereich;
                $this->ueberschrift = $this->data->ueberschrift;
                $this->inhalt = $this->data->inhalt;
                $this->schlagworte = $this->data->schlagworte;
                $this->berechtigung = $this->data->berechtigung;
                $this->userid = $this->data->userid;
                $this->loadFiles();
                // Log::info("  ueberschrift = ",[ $this->ueberschrift]);

                $this->editMode = true;
            }
        } else {
            $this->resetInputFields();
        }
    }

    public function resetInputFields()
    {
        // Log::info('resetInputFields');
        $this->files = [];

        session()->put('files', $this->files);

        $this->modelId = 1000000 + Auth::id();

        $this->bereich = '';
        $this->ueberschrift = '';
        $this->inhalt = ''; // Reset CKEditor Inhalt
        $this->schlagworte = '';
        $this->berechtigung = 0;
        $this->userid = 0;
        $this->editMode = false;
        $this->link = '';
    }

    public function loadFiles(){

        if ($this->data && $this->data->files()){
            $this->files = $this->data->files()->orderby('sort', 'asc')->get();
            $this->files = $this->files->all();

            session()->put('files', $this->files);

            // Log::info('in LoadFiles()');
            $this->logFiles();

        }
    }

    public function render()
    {
        // Log::info('render() ID:',[$this->modelId]);

        //$files = $this->files;

        return view('livewire.pages.create-data-component')->layout('layouts.app');
    }

    public function updated($field)
    {
        // Löst das Browser-Event zur Initialisierung von CKEditor aus
        //$this->dispatch('init-ckeditor');
        // Log::info('Updated', [$field]);
    }

    public function updateInhalt($content)
    {
        // Log::info('updateInhalt aktualisiert in Komponente:', [$content, $this->inhalt]);
        // $this->inhalt = $content; // Inhalt in der Komponente speichern
    }

    private function isInArray($array, $fn)
    {
        // Log::info('inArray');
        $found = false;
        if (!$array) {
            return $found;
        }
        foreach ($array as $value) {
            if ($value->file_path === $fn) {
                $found = true;
                break;
            }
        }
        return $found;
    }

    public function updatedInputfiles($value)
    {

        // Log::info('updatedInputfiles');
        $this->validate([
            'inputfiles.*' => 'mimes:jpg,png,pdf,gif|max:2048',
        ]);


        $zugefuegt = 0;
        foreach ($value as $file) {
            $originalFileName = $file->getClientOriginalName();

            $filePath = $file->storeAs('uploads', $originalFileName, 'public');

            $zugefuegt += $this->_addFile( $originalFileName);

        }




        // session()->flash('anzmessage', sprintf('Anzahl hinzugefügt: %d', [$zugefuegt]));
    }

    private function _addLink($name){
        return $this->_addAnhang($name, 1);
    }
    private function _addFile($name){
        return $this->_addAnhang($name, 0);
    }

    private function _addAnhang($name, $art){
        $result = 0 ;
        $this->files = session('files');

        $sortnum = 0;
        if ($this->files && count($this->files) > 0)
            $sortnum = $this->files[count($this->files)-1]->sort + 1;

        if (!$this->isInArray($this->files, $name)) {

            $fileModel = new File();
            $fileModel->setConnection($fileModel->getConnectionName());
            $fileModel->data_id = $this->modelId;
            $fileModel->file_path = $name;
            $fileModel->art = $art;
            $fileModel->sort = $sortnum + 1;
            //dd([$this->files, $fileModel]);
            try {
               $this->files[] = $fileModel;  /// <<<< FEHLER HIER
            } catch(Exception $e) {
                Log::error( [ "The exception code is: ", $e->getCode() ]);
            }

            $result = 1 ;

        }
        session()->put('files', $this->files);
        // Log::info('_addAnhang()');
        $this->logFiles();
        return $result ;
    }

    public function logFiles(){
        $this->files = session('files');
        foreach ($this->files as $file) {
            Log::info('Files:', [$file->id, $file->data_id, $file->file_path, $file->sort]);
        }
    }

    public function addLink()
    {
        // Log::info('addLink');
        $this->validate([
            'link' => 'required',
        ]);

        $count = $this->_addAnhang($this->link, 1);

        $this->link = '';

        $this->inputfiles = '';


    }

    public function store()
    {
        // Log::info('store',[ $this->id ]);

        $this->validate();

        $doChange = false ;
        $oldId = $this->modelId;
        if ($this->modelId > 10000){

            $doChange = true ;
            $this->modelId = null;
        }

        $data = Data::updateOrCreate(
            ['id' => $this->modelId], // Bedingungen, nach denen der Datensatz gesucht wird
            [
                'bereich' => $this->bereich,
                'ueberschrift' => $this->ueberschrift,
                'inhalt' => $this->inhalt,
                'schlagworte' => strtolower($this->schlagworte),
                'berechtigung' => $this->berechtigung,
                'userid' => $this->userid,
                'inhalt' => $this->inhalt,
            ], // Werte, die erstellt oder aktualisiert werden sollen
        );


        $this->files = session('files');

        foreach ($this->files as $key => $file){

            try {
                $file->data_id = $data->id;
                $file->save();

            } catch(Exception $e) {
                Log::error( [ "Store:::The exception code is: ", $e->getCode() ]);
            }
        }

        session()->flash('message', 'Data created successfully.');
        return redirect()->route('home'); // Beispiel: Route 'home'
    }



    public function abort()
    {
        return redirect()->route('home'); // Beispiel: Route 'home'
    }

    public function loeschen($pid){
        $file = File::find($pid);
        if ($file){
            $file->delete();
        }

        $this->loadFiles();
    }
}

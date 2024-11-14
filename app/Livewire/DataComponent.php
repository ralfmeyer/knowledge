<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Data;
use App\Models\File;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use League\CommonMark\CommonMarkConverter;


class DataComponent extends Component
{

    public $dataList;

    public $filterBereich = [];
    public $filterUeberschrift = '';
    public $filterInhalt = '';
    public $filterSchlagworte = '';

    public $sql = '';
    public $auswahlBereich = [];
    public $showForm = false;

    protected $rules = [
        'bereich' => 'required|max:80',
        'ueberschrift' => 'required|max:80',
        'inhalt' => 'required',
        'schlagworte' => 'required|max:255',
    ];

    public function mount(){

        if (session()->has('filterBereich')) {
            $this->filterBereich = session('filterBereich');
        }

        $query = Data::query();
        $userId = Auth::id();

        $query = $query->where(function($query) use ($userId) {
            // Bedingung für "berechtigung"
            $query->where('berechtigung', 0)
                ->orWhere(function($query) use ($userId) {
                    $query->where('berechtigung', 1)
                            ->where('userid', $userId);
                });
        })->with('files');



        $this->auswahlBereich = $query->distinct()->orderBy('bereich')->pluck('bereich');

    }

    public function render()
    {
        $this->dataList = $this->Abfrage();

        return view('livewire.data-component');
    }

    public function updatedFilterbereich(){
        session()->put('filterBereich', $this->filterBereich);
    }


    public function Abfrage(){
        $userId = Auth::id(); // Holt die ID des aktuell angemeldeten Benutzers

        $splitUeberschrift  = explode(' ', $this->filterUeberschrift);
        $splitInhalt  = explode(' ', $this->filterInhalt);
        $splitSchlagworte  = explode(' ', $this->filterSchlagworte);

        $query = Data::query();

        if (count($this->filterBereich) != 0){
            $query = $query->whereIn('bereich', $this->filterBereich);
        }

        if (count($splitUeberschrift) > 0){
            $query = $query->where(function($query) use ($splitUeberschrift) {
                // Bedingung für "ueberschrift" - sie soll einen Wert aus $splitUeberschrift enthalten
                foreach ($splitUeberschrift as $value) {
                    $query->Where('ueberschrift', 'like', '%' . $value . '%');
                }
                });
        }

        if (count($splitInhalt) > 0){
            $query = $query->where(function($query) use ($splitInhalt) {
                // Bedingung für "inhalt" - sie soll einen Wert aus $splitInhalt enthalten
                foreach ($splitInhalt as $value) {
                    $query->Where('inhalt', 'like', '%' . $value . '%');
                }
            });
        }

        if (count($splitSchlagworte) > 0){
            $query = $query->where(function($query) use ($splitSchlagworte) {
                // Bedingung für "schlagworte" - sie soll einen Wert aus $splitSchlagworte enthalten
                foreach ($splitSchlagworte as $value) {
                    $query->Where('schlagworte', 'like', '%' . $value . '%');
                }
            });
        }

        $query = $query->where(function($query) use ($userId) {
            // Bedingung für "berechtigung"
            $query->where('berechtigung', 0)
                ->orWhere(function($query) use ($userId) {
                    $query->where('berechtigung', 1)
                            ->where('userid', $userId);
                });
        });
        // $this->sql = $query->toRawSql();
        $result = $query->get();
        $converter = new CommonMarkConverter();

        foreach ($result as $key => $item){

            // $result[$key]['inhaltHtml'] = $converter->convert($item->inhalt)->getContent();
            $item->inhaltHtml = $converter->convert($item->inhalt)->getContent();

        }
        //dd($result);
        return $result;
        //return $query->get();
    }

    public function delete($id)
    {
        File::where('data_id', $id)->delete();
        Data::find($id)->delete();
        session()->flash('message', 'Data deleted successfully.');
    }
}

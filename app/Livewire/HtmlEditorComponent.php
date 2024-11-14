<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\Data;
use League\CommonMark\CommonMarkConverter;

class HtmlEditorComponent extends Component
{

    public $inhalt;
    public $inhaltMde;
    public $modelId;
    public $inhaltMdeHtml;

    public function mount( $pid = null)
    {
        if ($pid){
            $this->modelId = $pid;
            $data = Data::findOrFail($pid);
            if ($data) {
                Log::info('Mount()');
                $this->inhalt = $data->inhalt;
                $this->inhaltMde = $data->inhalt;
            }
        }
    }

    public function render()
    {
        Log::info('render()');
        return view('livewire.html-editor-component')->layout('layouts.app');


    }


    protected $rules = [
        'inhalt' => 'required',
    ];


    public function updated($field)
    {
        // Löst das Browser-Event zur Initialisierung von CKEditor aus
    }


    public function updateInhalt($value)
    {
        Log::info('Value:', [$value]);
        // $this->inhalt = $value;
    }

    public function updateHtml()
    {
        Log::info('updateHtml:');
        // $this->inhalt = $value;

        $converter = new CommonMarkConverter();
        //dd($converter->convert($this->inhaltMde)->getContent());
        $this->inhaltMdeHtml = $converter->convert($this->inhaltMde)->getContent();
    }

    public function store(){
        $data = Data::findOrFail($this->modelId);
        if ($data){
            $data->inhalt = $this->inhaltMde;
            // dd($this->inhaltMde);
            $data->save();
        }
        return redirect()->route('home'); // Beispiel: Route 'home'
    }
}

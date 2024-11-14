<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Log;

class TestComponent extends Component
{
    public $titel = 'Test';
    public $inhalt = '<h1>Test</h1><br>Hallo<br><p>sdkfs kfs dsjf f sdfjs fsdj fjdskjf ksjf j jdsjf jskfjkl fkjfjs flaslf jdf </p><p>ssdfdkfs sdffs dsjf f sdfjsdf fsdj fjdskjdsdff ksjf j jddsfsjf jskfjkl fkjfjs flaslf jdfsdf </p>';
    public $id = 33;
    public function render()
    {

        return view('livewire.test-component')->layout('layouts.app');
    }

    public function test(){
        $this->titel = $this->titel . " - Test ";
        $this->inhalt = $this->inhalt . '<p>ssdfdkfs sdffs dsjf f sdfjsdf fsdj fjdskjdsdff ksjf j jddsfsjf jskfjkl fkjfjs flaslf jdfsdf </p>';
        $this->dispatch('inhaltGeaendert', ['inhalt' => $this->inhalt]);
        // DO
    }


    public function updatedTitel($value)
    {
        Log::info('updatedTitel');

        // Event auslösen, wenn sich $titel ändert
        $this->dispatch('titelGeaendert', ['titel' => $value]);
    }

    public function updatedInhalt($value)
    {
        Log::info('updatedInhalt');

        // Event auslösen, wenn sich $titel ändert
        $this->dispatch('inhaltGeaendert', ['inhalt' => $this->inhalt]);
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;

class ResizeableBox extends Component
{

    public $size = 300; // Anfangsgröße

    public function updatedSize($value)
    {
        // Optional: Größe in der Datenbank speichern oder verarbeiten
    }

    public function render()
    {
        return view('livewire.resizeable-box')->layout('layouts.app');
    }
}

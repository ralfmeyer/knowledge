<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\File;
use Illuminate\Support\Facades\Log;


class FilesComponent extends Component
{
    public $id;
    public $files;

    public function mount($id)
    {
        Log::info('FilesComponent ID', [ $this->id()]);
        $this->id = $id;
        //$this->setid($id);
        //Log::info('FilesComponent ID', [ $this->id()]);

    }
    public function render()
    {
        $files = $this->files;
        $this->files = File::where('data_id', $this->id)->get();
        Log::info("render()");
        session()->put('files', $this->files);
        return view('livewire.files-component', [$files]);
    }

    #[On('renew')]
    public function renew(){

    }

}

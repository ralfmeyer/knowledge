<?php

use Livewire\Volt\Component;
use App\Models\Data;
use App\Models\User;
use Illuminate\Log;

new class extends Component {
    public $editMode = false;

    public $id, $bereich, $ueberschrift, $inhalt, $schlagworte, $berechtigung, $userid;
    public $benutzer;
    public $auswahlBereich;
    public $auswahlUsers;

    protected $rules = [
        'bereich' => 'required|max:80',
        'ueberschrift' => 'required|max:80',
        'inhalt' => 'required',
        'schlagworte' => 'required|max:255',
        'berechtigung' => 'required',
    ];

    public function mount($id = null)
    {
        if ($id) {
            $data = Data::find($id);
            if ($data) {
                $this->id = $id;
                $this->bereich = $data->bereich;
                $this->ueberschrift = $data->ueberschrift;
                $this->inhalt = $data->inhalt;
                $this->schlagworte = $data->schlagworte ;
                $this->berechtigung = $data->berechtigung ;
                $this->userid = $data->userid;
                $this->editMode = true ;

            }
        }
        else {
            $this->resetInputFields();
        }

        $this->auswahlBereich = Data::distinct()->pluck('bereich');
        $this->auswahlUsers = User::select('id', 'name')->get();


    }

    public function updateInhalt($value)
    {
        Log::info('Value:', [$value]);
        $this->inhalt = $value;
    }

    public function store()
    {

        $this->validate();

        $data = Data::updateOrCreate(
            ['id' => $this->id], // Bedingungen, nach denen der Datensatz gesucht wird
            [
                'bereich' => $this->bereich,
                'ueberschrift' => $this->ueberschrift,
                'inhalt' => $this->inhalt,
                'schlagworte' => strtolower($this->schlagworte),
                'berechtigung' => $this->berechtigung,
                'userid' => $this->userid,
            ], // Werte, die erstellt oder aktualisiert werden sollen
        );

        session()->flash('message', 'Data created successfully.');
        return redirect()->route('home'); // Beispiel: Route 'home'

    }

    public function resetInputFields()
    {
        $this->id = -1;
        $this->bereich = '';
        $this->ueberschrift = '';
        $this->inhalt = ''; // Reset CKEditor Inhalt
        $this->schlagworte = '';
        $this->berechtigung = 0;
        $this->userid = 0;
        $this->editMode = false;
    }

    public function abort(){
        return redirect()->route('home'); // Beispiel: Route 'home'
    }
}; ?>


<section>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $editMode ? 'Eintrag ändern' : 'Neuen Eintrag anlegen' }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 ">


            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full">

                    <form wire:submit.prevent="{{ $editMode ? 'store' : 'store' }}" class="flex flex-col space-y-3" id="myForm">
                        <input type="hidden" id="id" wire:model="id">
                        <div class="flex flex-col">
                            <label for="bereich">Bereich</label>
                            <input type="text" id="bereich" wire:model="bereich" placeholder="Bereich"
                                class="border px-2" list="auswahlBereich">
                            <datalist id="auswahlBereich">
                                @foreach ($auswahlBereich as $auswahl)
                                    <option value="{{ $auswahl }}">{{ $auswahl }} </option>
                                @endforeach
                            </datalist>
                            <x-input-error :messages="$errors->get('bereich')" class="mt-2" />
                        </div>

                        <div class="flex flex-col">
                            <label for="ueberschrift">Überschrift</label>
                            <input type="text" id="ueberschrift" wire:model="ueberschrift" placeholder="Überschrift"
                                class="border px-2">
                                <x-input-error :messages="$errors->get('ueberschrift')" class="mt-2" />
                        </div>

                        <div class="flex flex-col"  wire:ignore.self>

                            <label for="editor">Inhalt</label>

                            <div class="">
                                <div id="editor">
                                    {!! $inhalt !!} <!-- Hier wird der Inhalt ausgegeben -->
                                </div>
                            </div>



                        </div>
                        <x-input-error :messages="$errors->get('inhalt')" class="mt-2" />
                            <div class="flex flex-col">
                            <label for="schlagworte">Schlagworte</label>
                            <input type="text" id="schlagworte" wire:model="schlagworte" placeholder="Schlagworte"
                                class="border px-2">
                            <x-input-error :messages="$errors->get('schlagworte')" class="mt-2" />
                        </div>
                        <div class="flex flex-row space-x-2">
                            <div class="flex flex-col w-1/2">
                                <label for="berechtigung">Berechtigung</label>
                                <select id="berechtigung" wire:model="berechtigung" class="border px-2">
                                    <option value='0'>Alle</option>
                                    <option value='1'>Benutzer</option>
                                </select>
                                <x-input-error :messages="$errors->get('berechtigung')" class="mt-2" />
                                    Berechtigung: {{ $berechtigung }}
                            </div>

                            <div class="flex flex-col w-1/2">
                                <label for="userid">Benutzer</label>
                                <select id="userid" wire:model="userid" class="border px-2">
                                    <option value='0'>Keiner gewählt</option>
                                    @foreach ($auswahlUsers as $user)
                                        <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('userid')" class="mt-2" />
                        </div>



                        <div class="flex justify-end space-x-2">
                            <button type="button" wire:click="abort()"
                                class="bg-yellow-500 text-white px-4 ">Abbrechen</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 ">
                                {{ $editMode ? 'Aktualisieren' : 'Erstellen' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.umd.js"></script>
        <script type="module">
            document.addEventListener('DOMContentLoaded', function () {

                // Funktion zum Initialisieren von CKEditor
                function initializeCKEditor() {
                    if (document.querySelector('#editor')) {
                        const { ClassicEditor, Essentials, Bold, Italic, Font, Paragraph, CodeBlock } = CKEDITOR;

                        ClassicEditor
                            .create(document.querySelector('#editor'), {
                                plugins: [CodeBlock, Essentials, Bold, Italic, Font, Paragraph],
                                toolbar: [
                                    'undo', 'redo', '|', 'bold', 'italic', '|',
                                    'codeBlock', 'fontSize', 'fontFamily', 'fontBackgroundColor', 'fontColor'
                                ]
                            })
                            .then(editor => {
                                window.editor = editor;

                                // Event-Listener für Änderungen im CKEditor
                                /*
                                editor.model.document.on('change:data', () => {
                                    // Synchronisiere den Inhalt des CKEditor mit der Livewire-Variable
                                    @this.set('inhalt', editor.getData());
                                });
                                */
                                document.querySelector('#myForm').addEventListener('submit', function () {
                                    // document.querySelector('#inhalt').value = editor.getData(); // Synchronisiere den CKEditor-Inhalt
                                    @this.set('inhalt', editor.getData());
                                });
                            })
                            .catch(error => {
                                console.error('Fehler bei der CKEditor-Initialisierung:', error);
                            });
                    }
                }

                // CKEditor nur initialisieren, wenn Livewire das DOM nicht aktualisiert
                Livewire.hook('message.processed', (message, component) => {
                    // Überprüfe, ob der Editor bereits existiert

                    if (!window.editor) {
                        initializeCKEditor();
                    } else {
                        // Setze den Editor-Inhalt auf den aktuellen Wert, wenn bereits initialisiert

                        window.editor.setData(@this.get('inhalt'));

                    }
                });

                // Initialisierung des Editors beim ersten Laden
                initializeCKEditor();
            });
        </script>
        @endpush

</section>

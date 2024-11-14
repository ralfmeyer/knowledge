
<div wire:key="create-data-component-{{ $this->id() }}">
    <script>
        const EditorComponentID = '{{ $this->id() }}';
        console.log('ID der Livewire-Komponente-create-data-component:', EditorComponentID );

    </script>




    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $editMode ? 'Eintrag ändern' : 'Neuen Eintrag anlegen' }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 ">


            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full" >

                    <form wire:submit.prevent="store" class="flex flex-col space-y-3" id="myForm">
                        <div class="flex flex-col">
                            <div>
                                @if ($editMode === true)

                                @else
                                    NEU: {{ $modelId }}
                                @endIf
                            </div>
                        </div>
                        <input type="hidden" id="id" wire:model="modelId">
                        <div class="flex flex-row w-full items-center">
                            <div class="w-2/12">
                                <label for="bereich" class="font-bold">Bereich</label>
                            </div>
                            <div  class="w-10/12">
                                <input type="text" id="bereich" wire:model="bereich" placeholder="Bereich" class="border px-2 w-full" list="auswahlBereich">
                                <datalist id="auswahlBereich">
                                    @foreach ($auswahlBereich as $auswahl)
                                        <option value="{{ $auswahl }}">{{ $auswahl }} </option>
                                    @endforeach
                                </datalist>
                                <x-input-error :messages="$errors->get('bereich')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row w-full items-center">
                            <div class="w-2/12">
                                <label for="ueberschrift" class="font-bold">Überschrift</label>
                            </div>
                            <div class="w-10/12">
                                <input type="text" id="ueberschrift" wire:model="ueberschrift" placeholder="Überschrift" class="border px-2 w-full">
                                <x-input-error :messages="$errors->get('ueberschrift')" class="mt-2" />
                            </div>
                        </div>

                        <!------------------------------------------------------>
                        <!-- EDITOR -------------------------------------------->
                        <!------------------------------------------------------>
                        <div class="flex flex-row w-full items-start">
                            <div class="w-2/12">
                                <label for="inhalt" class="font-bold">Inhalt</label>
                            </div>
                            <div class="w-10/12">
                                <textarea id="inhalt" wire:model.lazy="inhalt" class="w-full h-40 resize-y overflow-auto border p-2"></textarea>
                                <x-input-error :messages="$errors->get('inhalt')" class="mt-2" />
                            </div>
                        </div>
                        <!------------------------------------------------------>
                        <!-- EDITOR ENDE --------------------------------------->
                        <!------------------------------------------------------>
                        <x-input-error :messages="$errors->get('inhalt')" class="mt-2" />

                        <div class="flex flex-row w-full items-center">
                            <div class="w-2/12">
                                <label for="schlagworte" class="font-bold">Schlagworte</label>
                            </div>
                            <div class="w-10/12">
                                <input type="text" id="schlagworte" wire:model="schlagworte" placeholder="Schlagworte" class="border px-2 w-full">
                                <x-input-error :messages="$errors->get('schlagworte')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex flex-row items-center">
                            <div class="w-2/12">
                                <label for="berechtigung" class="font-bold">Berechtigung</label>
                            </div>
                            <div class="w-10/12 flex flex-col w-1/2">

                                <select id="berechtigung" wire:model="berechtigung" class="border px-2 w-full">
                                    <option value='0'>Alle</option>
                                    <option value='1'>Benutzer</option>
                                </select>
                                <x-input-error :messages="$errors->get('berechtigung')" class="mt-2" />

                            </div>
                        </div>
                        <div class="flex flex-row">
                            <div class="w-2/12">&nbsp;</div>
                            <div class="w-10/12 flex flex-row items-center">
                                <div class="">
                                    <label for="userid" class="font-bold">Benutzer:&nbsp;</label>
                                </div>
                                <div class="">
                                    <select id="userid" wire:model="userid" class="border w-full">
                                        <option value='0'>Keiner gewählt</option>
                                        @foreach ($auswahlUsers as $user)
                                            <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('userid')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" wire:click="abort()"
                                class="bg-yellow-500 text-white px-4 ">Abbrechen</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 ">
                                {{ $editMode ? 'Aktualisieren' : 'Erstellen' }}
                            </button>
                        </div>
                    </form>



                        <div class="flex flex-row mt-6 items-center">
                            <div class="w-2/12">

                                <label for="link" class="font-bold">Link anhängen</label>
                            </div>
                            <div class="w-10/12 flex flex-row border border-gray-600 items-center">
                                <div class=" bg-orange-300 text-white px-4 mx-2">
                                    <a href="#" wire:click="addLink()">Add</a>
                                </div>
                                <input type="text" id="link" wire:model="link"
                                    placeholder="Fügen Sie hier einen neuen Link ein und klicken Sie auf 'Add' "
                                    class="px-2 border-0 w-full">
                                <!-- x-input-error :messages="$errors - > get('link')" class="mt-2" / -->
                            </div>
                        </div>


                        <div class="flex flex-row mt-6 items-center">
                            <div class="w-2/12">
                                <label for="inputfiles" class="font-bold">Dateien anhängen</label>
                            </div>
                            <div class="w-10/12 flex flex-row border border-gray-500 p-2 items-center">
                                <div>
                                    <input id="inputfiles" type="file" wire:model="inputfiles" multiple class=" w-full">
                                </div>
                                @error('inputfiles.*')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                                @if (session()->has('anzmessage'))
                                    <div>{{ session('anzmessage') }}</div>
                                @endif
                            </div>
                        </div>


                        <!------------------------------------------------------>
                        <!-- FilesComponent------------------------------------->
                        <!------------------------------------------------------>
                        @if ($files)
                        <div class="flex flex-row w-full mt-6">
                            <div class="w-2/12">
                                <label class="font-bold">Anhänge: ({{ count($files) }})</label>
                            </div>
                            <div class="flex flex-col w-10/12">

                                <div class="flex flex-row border-b border-black">
                                    <div class="w-10/12">
                                        Pfad
                                    </div>
                                    <div class="w-1/12">
                                        Sortierung
                                    </div>
                                    <div class="w-1/12">
                                        Aktion
                                    </div>
                                </div>

                                @foreach ($files as $key => $file)
                                    <div class="flex flex-row" wire:key="file-{{ $file->key }}">
                                        <div class="w-10/12">
                                            <div class="float-start pr-2 text-blue-500">
                                                @if ($file->art === 0)
                                                    <x-fluentui-arrow-download-16-o class="h-6" />
                                                @elseif ($file->art === 1)
                                                   <x-fluentui-link-16-o class="h-6 " />
                                                @endif
                                            </div>

                                            @if ($file->art === 0)
                                                <a href="{{ asset('storage/uploads/' . $file->file_path) }}" target="_blank">{{ $file->file_path }}</a>
                                            @elseif ($file->art === 1)

                                                <a href="{{ $file->file_path }}" target="_blank">{{ $file->file_path }}</a>
                                            @endif

                                        </div>
                                        <div class="w-1/12">
                                            {{ $file->sort }}
                                        </div>
                                        <div class=" w-1/12">
                                            <a href="#" wire:click="loeschen({{ $file->id }})" class="hover:underline">Löschen</a>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                        @endif
                        <!------------------------------------------------------>
                        <!-- FilesComponent------------------------------------->
                        <!------------------------------------------------------>

                        <div class="flex flex-col mt-6">
                            <div>
                                <label class="font-bold">
                                    Inhaltsvorschau :
                                </label>
                            </div>
                            <div class="border border-gray-500 bg-slate-50 text-sm font-mono p-2 ">
                                @php
                                    $beispieltext = '<p>Erstellt eine Datei im Ordner tests\Unit&nbsp;</p><pre><code class="language-plaintext">php artisan make:test ExampleTest --unit </code></pre>';
                                @endphp
                                <div class="flex flex-col">


                                    <div class="mb-4">
                                        {!! $inhalt !!}
                                    </div>
                                </div>


                            </div>
                        </div>


                    <div class="flex flex-col mt-6">
                        <div>
                            <label class="font-bold">
                                Mustertext :
                            </label>
                        </div>
                        <div class="border border-gray-500 bg-slate-50 text-sm font-mono p-2 ">
                            @php
                                $beispieltext = '<p>Erstellt eine Datei im Ordner tests\Unit&nbsp;</p><pre><code class="language-plaintext">php artisan make:test ExampleTest --unit </code></pre>';
                            @endphp
                            <div class="flex flex-col">


                                <div class="mb-4">
                                    {{ $beispieltext }}
                                </div>
                                <div>
                                    {!! $beispieltext !!}
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>





</div>

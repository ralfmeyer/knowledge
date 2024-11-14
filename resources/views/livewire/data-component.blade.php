<div class="">

        <div class="py-4" x-data="{ showForm: @entangle('showForm') }" x-on:click.self="showForm = false"
            x-on:keydown.escape.window="showForm = false">
            <div class="flex flex-row">

                    <div class="w-2/12 mx-2 p-2 text-sm border border-gray-200 bg-white rounded-md">
                        <div class="border-b border-gray-400 mb-2">Bereichsfilter</div>
                        @foreach ($auswahlBereich as $bereich)
                            <div class="mb-1">
                                <input class="mcheckbox" type="checkbox" id="checkbox-{{ $loop->index }}" name="bereiche[]"
                                    value="{{ $bereich }}" wire:model.lazy="filterBereich">
                                <label for="checkbox-{{ $loop->index }}">{{ $bereich }}</label>
                            </div>
                        @endforeach
                    </div>


                    <div class="w-10/12 mx-auto sm:pr-6 lg:pr-8">
                        <div
                            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                            <div class="p-2 pt-2 text-gray-900 dark:text-gray-100">
                                <!-- Filterform -->
                                <div class="flex flex-row items-center space-x-2 text-sm mb-2">
                                    <div class="flex flex-col">
                                        <label for="filterUeberschrift" class="h-6">Überschrift</label>
                                        <input id="filterUeberschrift" wire:model.lazy="filterUeberschrift" type="Text" class="h-6" />
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="filterInhalt" class="h-6">Inhalt</label>
                                        <input id="filterInhalt" wire:model.lazy="filterInhalt" type="Text" class="h-6" />
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="filterSchlagworte" class="h-6">Schlagworte</label>
                                        <input id="filterSchlagworte" wire:model.lazy="filterSchlagworte" type="Text" class="h-6" />
                                    </div>
                                </div>

                                <!-- Liste der Datensätze -->
                                <div class="flex flex-col space-y-2">
                                    @foreach ($dataList as $item)
                                        <div x-data="{ expanded: false }"
                                            class="flex flex-col justify-between border border-gray-300 rounded-md bg-gray-100 p-2">
                                            <!-- Bereich -->
                                            <div class="flex flex-row justify-between border-b items-center">
                                                <div class="w-4/6 font-bold items-center flex flex-row">
                                                    <div>
                                                        <button @click="expanded = !expanded" class="mr-2">
                                                            <span x-show="!expanded"><x-fluentui-folder-20-o class="w-6" /></span>
                                                            <span x-show="expanded"><x-fluentui-folder-open-20-o class="w-6" /></span>
                                                        </button>
                                                    </div>
                                                    <div class="flex flex-row items-center">
                                                        <div class="m-2">{{ $item->ueberschrift }}</div>
                                                        @if ($item->berechtigung == 1)
                                                            <div><x-fluentui-shield-person-20-o class="text-orange-700 h-6" title="Privat - geschützt" /></div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="w-1/6">Bereich: {{ $item->bereich }}</div>
                                                <div class="text-xs w-1/6 text-right">{{ $item->updated_at }}</div>
                                            </div>

                                            <div class="bg-gray-50 border border-gray-400 p-2 w-full rounded">
                                                <div :class="expanded ? 'max-h-none' : 'max-h-24'" class="overflow-y-auto transition-all duration-300">
                                                    {!! $item->inhaltHtml !!}
                                                </div>
                                            </div>

                                            <div x-show="expanded">
                                                @if (count($item->files) > 0)
                                                    <div class="mt-2 p-2 flex flex-row border border-gray-300 rounded-md bg-gray-100 text-sm">
                                                        <div class="w-1/12">Anhänge:</div>
                                                        <div class="flex flex-col w-11/12">
                                                            @foreach ($item->files as $file)
                                                                <div class="px-1">
                                                                    <div class="text-blue-500 border-b border-b-gray-400">
                                                                        @if ($file->art === 0)
                                                                            <a href="{{ asset('storage/uploads/' . $file->file_path) }}" title="{{ $file->file_path }}" target="_blank">
                                                                                <x-fluentui-arrow-download-16-o class="h-6 float-start" />
                                                                                {{ $file->file_path }}
                                                                            </a>
                                                                        @elseif ($file->art === 1)
                                                                            <a href="{{ $file->file_path }}" title="{{ $file->file_path }}" target="_blank">
                                                                                <x-fluentui-link-16-o class="h-6 float-start" />
                                                                                {{ $file->file_path }}
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex flex-row items-center justify-between">
                                                <div class="flex-1 text-xs items-center">
                                                    <div class="float-start">[ {{ $item->schlagworte }} ]</div>
                                                    <div x-show="!expanded">
                                                        @foreach ($item->files as $file)
                                                            <div class="float-start px-1">
                                                                <div class="text-blue-500">
                                                                    @if ($file->art === 0)
                                                                        <a href="{{ asset('storage/uploads/' . $file->file_path) }}" title="{{ $file->file_path }}" target="_blank">
                                                                            <x-fluentui-arrow-download-16-o class="h-5" />
                                                                        </a>
                                                                    @elseif ($file->art === 1)
                                                                        <a href="{{ $file->file_path }}" title="{{ $file->file_path }}" target="_blank">
                                                                            <x-fluentui-link-16-o class="h-5" />
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <!-- Aktionen (Bearbeiten/Löschen) -->
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('ckedit', ['pid' => $item->id]) }}" class="bg-green-200 hover:bg-green-400 text-white p-1 rounded">
                                                        <x-fluentui-document-edit-16-o class="h-5" />
                                                    </a>
                                                    <a href="{{ route('edit', ['pid' => $item->id]) }}" class="bg-blue-200 hover:bg-blue-400 text-white p-1 rounded">
                                                        <x-fluentui-document-edit-16-o class="h-5" />
                                                    </a>
                                                    <button type="button" wire:click="delete({{ $item->id }})" class="bg-red-200 hover:bg-red-400 text-white p-1 rounded">
                                                        <x-fluentui-delete-16-o class="h-5" />
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                </div>

            </div>
        </div>

</div>

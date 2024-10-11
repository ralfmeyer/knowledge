<div>
    <style>
        code{
            background: hsla(0, 0%, 78%, .3);
    border: 1px solid #c4c4c4;
    border-radius: 2px;
    color: #353535;
    direction: ltr;
    font-style: normal;
    min-width: 200px;
    padding: 1em;
    margin-block: 1em;
        }
        </style>
    <div class="py-4" x-data="{ showForm: @entangle('showForm') }" x-on:click.self="showForm = false"
        x-on:keydown.escape.window="showForm = false">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Liste der Datensätze -->
                    <div class="flex flex-row items-center space-x-2 text-sm mb-2">
                        <div class="flex flex-col">
                            <label for="filterBereich" class="h-6">Bereich</label>
                            <select id="filterBereich" wire:model.lazy="filterBereich" class="border px-2 p-0 h-6 w-32">
                                <option value=''>- No -</option>
                                @foreach ($auswahlBereich as $bereich)
                                    <option value='{{ $bereich }}'>{{ $bereich }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label for="filterUeberschrift" class="h-6">Überschrift</label>
                            <input id="filterUeberschrift" wire:model.lazy="filterUeberschrift" type="Text" class="h-6"/>
                        </div>
                        <div class="flex flex-col">
                            <label for="filterInhalt" class="h-6">Inhalt</label>
                            <input id="filterInhalt" wire:model.lazy="filterInhalt" type="Text" class="h-6"/>
                        </div>
                        <div class="flex flex-col">
                            <label for="filterSchlagworte" class="h-6">Schlagworte</label>
                            <input id="filterSchlagworte" wire:model.lazy="filterSchlagworte" type="Text" class="h-6"/>
                        </div>
                    </div>

                    <!-- div class="bg-gray-200 p-2 font-mono text-sm">
                    {{ $sql }}
                    </div -->
                    <div class="flex flex-col space-y-2">
                        @foreach ($dataList as $item)
                            <div class="flex flex-col justify-between border border-gray-300 rounded-md bg-gray-100 p-4">
                                <!-- Bereich -->
                                <div class="flex flex-row justify-between border-b items-center">
                                    <div class="w-4/6 font-bold">
                                        {{ $item->ueberschrift }}
                                    </div>
                                    <div class="w-1/6">
                                        {{ $item->bereich }}
                                    </div>
                                    <div class="text-xs w-1/6 text-right">
                                        {{ $item->created_at }}
                                    </div>
                                </div>
                                <div class="flex-1 bg-sky-100 p-2">
                                    {!! $item->inhalt !!}
                                </div>

                                <div class="flex flex-row items-center justify-between">
                                    <div class="flex-1 text-xs">
                                        [ {{ $item->schlagworte }} ]
                                    </div>

                                    <!-- Aktionen (Bearbeiten/Löschen) -->
                                    <div class="flex space-x-2">

                                        <a href="{{ route('edit', ['id' => $item->id]) }}" class="bg-blue-200 hover:bg-blue-400 text-white p-1 rounded"><x-fluentui-document-edit-16-o class="h-5"/></a>

                                        <button type="button" wire:click="delete({{ $item->id }})" class="bg-red-200 hover:bg-red-400 text-white p-1 rounded"><x-fluentui-delete-16-o class="h-5"/></button>
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

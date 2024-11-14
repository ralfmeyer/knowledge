<div>
    <div>{{ $titel }}</div>

    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <button type="button" wire:click="test()"
        class="border border-gray-600 rounded bg-red-200 py-2 px-4 mx-4">Test</button>

    <!------------------------------------------------------>
    <!-- FilesComponent------------------------------------->
    <!------------------------------------------------------>




    <!------------------------------------------------------>
    <!-- EDITOR -------------------------------------------->
    <!------------------------------------------------------>
    <div class="flex flex-col w-full h-40 min-h-16 bg-red-200">
        <label for="editor">Inhalt</label>
        <div class="w-full h-full">
            <textarea wire:model="inhalt" class="w-full h-full"></textarea>
        </div>
    </div>
    <!------------------------------------------------------>
    <!-- EDITOR ENDE --------------------------------------->
    <!------------------------------------------------------>


    <div class="flex flex-col w-full bg-green-100" wire:ignore>

        <livewire:filesComponent :id="$id" wire:key="myFiles-'$id'" />

    </div>

    <!------------------------------------------------------>
    <!-- FilesComponent------------------------------------->
    <!------------------------------------------------------>


    <div>
    {!! $inhalt !!}
    </div>



</div>

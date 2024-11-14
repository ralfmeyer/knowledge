<div wire:key="files-component-{{ $this->id() }}">
    <script>
        const FilesComponentID = '{{ $this->id() }}';
        console.log('ID der FilesComponent:', FilesComponentID );
    </script>
    <div>
        Count: {{ count( $files )}}
    </div>
</div>

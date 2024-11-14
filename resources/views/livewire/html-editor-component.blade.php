<div>
    <div class="w-4/5 m-auto mt-2 bg-white rounded-md p-2 border border-gray-200">
        <div class="flex flex-row w-full h-full">
            <div class="w-1/2">
                <form wire:submit.prevent="store" class="flex flex-col space-y-4 ">

                    <div wire:ignore class="pt-2">
                        <label for="editorMDE" class="font-bold text-xl pl-2">Inhalt</label>
                        <textarea id="editorMDE"></textarea>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Speichern
                    </button>

                </form>
            </div>

            <div class="flex flex-col w-1/2  ml-0.5">
                <div class="pt-2 font-bold text-xl pl-2">Inhaltsvorschau</div>
                <div class="p-2 border border-gray-300 rounded-md  h-full">
                {!! $inhaltMdeHtml !!}
                </div>
            </div>
        </div>
    </div>

@push('styles')

    <link rel="stylesheet" href="{{ asset('css/simplemde.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/simplemde.user.css') }}">
@endpush






    @push('scripts')

    <script src="{{ asset('js/simplemde.min.js') }}"></script>

    <script>

//        var simplemde = new SimpleMDE({
//                element: document.getElementById("editorMDE"),
//                initialValue: @json($inhaltMde)});

        var simplemde = new SimpleMDE({
                    element: document.getElementById("editorMDE"),
                    initialValue: @json($inhaltMde),
                    autofocus: true,
                    autosave: {
                        enabled: false,
                        uniqueId: "MyUniqueID",
                        delay: 1000,
                    },
                    blockStyles: {
                        bold: "__",
                        italic: "_",
                        code: "~~~"
                    },

                    forceSync: true,
                    hideIcons: ["guide", "heading"],
                    indentWithTabs: false,


                    insertTexts: {
                        horizontalRule: ["", "\n\n-----\n\n"],
                        image: ["![](http://", ")"],
                        link: ["[", "](http://)"],
                        table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
                    },
                    lineWrapping: true,
                    parsingConfig: {
                        allowAtxHeaderWithoutSpace: true,
                        strikethrough: false,
                        underscoresBreakWords: true,
                    },
                    placeholder: "Type here...",

                    promptURLs: true,
                    renderingConfig: {
                        singleLineBreaks: false,
                        codeSyntaxHighlighting: true,
                    },
                    shortcuts: {
                        drawTable: "Cmd-Alt-T"
                    },
                    showIcons: ["code", "table"],

                    spellChecker: true,
                    status: true,
                    status: ["autosave", "lines", "words", "cursor"], // Optional usage
                    status: ["autosave", "lines", "words", "cursor", {
                        className: "keystrokes",
                        defaultValue: function(el) {
                            this.keystrokes = 0;
                            el.innerHTML = "0 Anschläge";
                        },
                        onUpdate: function(el) {
                            el.innerHTML = ++this.keystrokes + " Anschläge";
                        }
                    }], // Another optional usage, with a custom status bar item that counts keystrokes
                    styleSelectedText: false,
                    tabSize: 4,
                    toolbar: [ "bold", "italic", "|", "unordered-list", "heading-1", "heading-2", "heading-3", "|", "fullscreen", "clean-block", "guide", ""],

                    toolbarTips: false,
                });

                setInterval(function() {
                @this.call('updateHtml'); // Methode der Livewire-Komponente aufrufen
            }, 1000); // Intervall in Millisekunden















        simplemde.codemirror.on("change", function(){
	        @this.set('inhaltMde', simplemde.value());
            // console.log(simplemde.value())
        });

    </script>

    @endpush
</div>

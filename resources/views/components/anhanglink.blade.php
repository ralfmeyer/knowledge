@props(['file', 'short'])

@php
    $linkColor = ''
@endphp

<div class="text-blue-500 hover:underline hover:font-bold flex flex-row">
    @if (!$short)

        @if ($file->art === 0)

            <a href="{{ asset('storage/uploads/' . $file->file_path) }}" title="{{ $file->file_path }}" target="_blank" class="w-full">
                <div class="flex flex-row items-center">
                    <div class="mr-2">
                        <x-fluentui-arrow-download-16-o class="h-6" />
                    </div>
                    <div class="w-full">
                        {{ $file->file_path }}
                    </div>
                </div>
            </a>
        @elseif ($file->art === 1)
            <a href="{{ $file->file_path }}" title="{{ $file->file_path }}" target="_blank">

                <div class="flex flex-row items-center">
                    <div class="mr-2">
                        <x-fluentui-link-16-o class="h-6" />
                    </div>
                    <div class="w-full">
                        {{ $file->file_path }}
                    </div>
                </div>

            </a>
        @elseif ($file->art === 2)
            <a href="{{ asset('storage/uploads/' . $file->file_path) }}" data-lightbox="galerie" data-title="{{ $file->file_path }}">

                <div class="flex flex-row items-center">
                    <div class="mr-2">
                        <x-fluentui-image-16-o class="h-6" />
                    </div>
                    <div class="w-full">
                        {{ $file->file_path }}
                    </div>
                </div>
            </a>
        @endif
    @else
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
                @elseif ($file->art === 2)
                    <a href="{{ asset('storage/uploads/' . $file->file_path) }}" data-lightbox="galerie" data-title="{{ $file->file_path }}">
                        <!-- img src="{{-- asset('storage/' . $bild->thumbnail) --}}" alt="{{-- $bild->titel --}}" class="w-64" -->

                        <x-fluentui-image-16-o class="h-5" title="{{ $file->file_path }}"/>
                    </a>

                @endif
            </div>
        </div>


    @endif
</div>

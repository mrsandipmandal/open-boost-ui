@props([
    'id' => $id ?? 'flash-modal-'.uniqid(),
    'title' => $title ?? 'Modal Title',
    'theme' => $theme ?? 'default',
    'size' => $size ?? 'md', // supported: sm, md, lg, xl, full
    'showFooter' => $showFooter ?? true,
    'showCloseButton' => $showCloseButton ?? true,
    // Bootstrap-specific options
    'modalClass' => $modalClass ?? '', // additional classes on .modal (e.g. "modal-blur")
    'dialogClass' => $dialogClass ?? '', // extra classes on .modal-dialog
    'centered' => $centered ?? false,   // add .modal-dialog-centered when true
])

@if($theme === 'bootstrap')
<div class="inline-block">

    <div class="modal {{ $modalClass }} fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog @if($size === 'sm') modal-sm @elseif($size === 'lg') modal-lg @elseif($size === 'xl') modal-xl @elseif($size === 'full') modal-fullscreen @endif @if($centered) modal-dialog-centered @endif {{ $dialogClass }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $title }}</h5>
                    @if($showCloseButton)
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    @endif
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
                @if($showFooter)
                    <div class="modal-footer">
                        @isset($footer)
                            {{ $footer }}
                        @else
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        @endisset
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@else

<div class="inline-block">

    <div class="fixed inset-0 flex items-center justify-center bg-black/50 z-50 hidden"
     id="{{ $id }}"
     data-flash-modal>
    <div class="bg-white rounded-lg shadow-lg w-full @if($size === 'sm') max-w-sm @elseif($size === 'md') max-w-md @elseif($size === 'lg') max-w-lg @elseif($size === 'xl') max-w-xl @elseif($size === 'full') w-full max-w-full @else max-w-lg @endif">
            <div class="px-4 py-3 border-b flex justify-between items-center">
                <h2 class="font-semibold text-lg">{{ $title }}</h2>
                @if($showCloseButton)
                    <button type="button" data-flash-modal-close>&times;</button>
                @endif
            </div>
            <div class="p-4">
                {{ $slot }}
            </div>
            @if($showFooter)
                <div class="px-4 py-3 border-t text-right">
                    @isset($footer)
                        {{ $footer }}
                    @else
                        <button type="button" class="mr-2" data-flash-modal-close>Close</button>
                    @endisset
                </div>
            @endif
        </div>
    </div>
</div>

@endif

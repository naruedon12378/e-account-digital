<div class="modal fade" id="{{ $name }}" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="title" aria-hidden="true">
    <div class="modal-dialog @if($attributes->has('size')) {{ $size }}@endif" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">@if($attributes->has('title')){{ $title }}@endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa-regular fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer d-block text-center">
                <x-button-close></x-button-close>
                @if ($attributes->has('autoClose'))
                <x-button id="btnSubmitModal" property='data-dismiss="modal"'>{{ __('file.Submit') }}</x-button>    
                @else
                <x-button id="btnSubmitModal">{{ __('file.Submit') }}</x-button>
                @endif
            </div>
        </div>
    </div>
</div>

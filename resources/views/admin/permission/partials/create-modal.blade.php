{{-- Krajee --}}
{{-- @php
    $config = [
        'browseOnZoneClick' => true,
        'overwriteInitial' => true,
        'theme' => 'fa5',
        'language' => 'th',
        'showUpload' => false,
        'allowedFileExtensions' => ["jpg", "jpeg", "gif", "png"],
    ];
@endphp --}}

<form id="form">
    <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.add') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">บทบาท</label>
                        <input class="form-control " name="name" id="name" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">คำอธิบาย</label>
                        <input class="form-control " name="description" id="description" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">กลุ่ม (ภาษาอังกฤษ)</label>
                        <input class="form-control " name="group_en" id="group_en" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">กลุ่ม (ภาษาไทย)</label>
                        <input class="form-control " name="group_th" id="group_th" />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="storeData()">{{ __('home.save') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        $(document).ready(function() {});
    </script>
@endpush

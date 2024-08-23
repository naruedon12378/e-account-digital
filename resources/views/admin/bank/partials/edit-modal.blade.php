<form id="form">
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.edit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eid">
                    <div class="mb-3">
                        <label class="form-label">{{ __('bank.bank_name_th') }}</label>
                        <input class="form-control " name="ename_th" id="ename_th" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('bank.bank_name_en') }}</label>
                        <input class="form-control " name="ename_en" id="ename_en" />
                    </div>
                    <div class="mb-3">
                        <div class="mb-3">
                            <label class="form-label">{{ __('bank.logo') }}</label><br />
                            <div class="text-center">
                                <img src="https://placehold.co/300x300" id="eshowimg"
                                    style="max-width: 100%; object-fit: cover;" height="300">
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="eimg" name="eimg"
                                    onchange="return fileValidation(this)" accept="image/*">
                                <label class="custom-file-label">{{ __('bank.choose_file') }}</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger btnReset">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="updateData()">{{ __('home.save') }}</a>
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

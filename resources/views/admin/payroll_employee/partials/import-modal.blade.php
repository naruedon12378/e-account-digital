<form id="importForm" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="modal-import" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Import</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <blockquote class="quote-warning text-sm" style="margin: 0 !important;">
                            <a href="{{ asset('template/IMPORT_PAYROLL_EMPLOYEE.xlsx') }}">Download this form
                                (.xlsx)</a>
                            to
                            prepare data to import
                        </blockquote>
                    </div>

                    <label>Upload File</label>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="import_doc" accept=".xlsx, .xls"
                                aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="import_doc">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.cancel') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="importData()">{{ __('home.save') }}</a>
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

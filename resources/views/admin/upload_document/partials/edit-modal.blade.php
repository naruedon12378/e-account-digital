<form id="form">
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">แก้ไขข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eid">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                {{ __('uploadDocument.select_type') }}
                            </blockquote>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <div class="icheck-primary icheck-inline">
                                <input type="radio" id="chb1" name="edoc_type" value="expenses" checked />
                                <label for="chb1">{{ __('uploadDocument.expenses') }}</label>
                            </div>
                            <div class="icheck-primary icheck-inline">
                                <input type="radio" id="chb2" name="edoc_type" value="revenues" />
                                <label for="chb2">{{ __('uploadDocument.revenues') }}</label>
                            </div>
                            <div class="icheck-primary icheck-inline">
                                <input type="radio" id="chb3" name="edoc_type" value="withheld_tax" />
                                <label for="chb3">{{ __('uploadDocument.withheld_tax') }}</label>
                            </div>
                            <div class="icheck-primary icheck-inline">
                                <input type="radio" id="chb4" name="edoc_type" value="unspecified" />
                                <label for="chb4">{{ __('uploadDocument.unspecified') }}</label>
                            </div>

                            <div class="text-muted mt-3 expenses_detail">
                                {{ __('uploadDocument.expenses_detail') }}
                            </div>
                            <div class="text-muted mt-3 revenues_detail" style="display: none;">
                                {{ __('uploadDocument.revenues_detail') }}
                            </div>
                            <div class="text-muted mt-3 withheld_tax_detail" style="display: none;">
                                {{ __('uploadDocument.withheld_tax_detail') }}
                            </div>
                            <div class="text-muted mt-3 unspecified_detail" style="display: none;">
                                {{ __('uploadDocument.unspecified_detail') }}
                            </div>
                        </div>

                        <div class="col-sm-12 mb-3">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                {{ __('uploadDocument.select_files') }}
                            </blockquote>
                        </div>

                        <div class="col-sm-12">
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="document" name="document"
                                            multiple>
                                        <label class="custom-file-label">เลือกไฟล์</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="updateData()">{{ __('home.save') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        $(document).ready(function() {});

        $("input[name='edoc_type']").on('change', function() {
            echkDocType();
        });

        function echkDocType() {
            type = $("input[name='edoc_type']:checked").val();
            if (type == 'expenses') {
                $('.expenses_detail').css('display', '');
                $('.revenues_detail').css('display', 'none');
                $('.withheld_tax_detail').css('display', 'none');
                $('.unspecified_detail').css('display', 'none');
            } else if (type == 'revenues') {
                $('.expenses_detail').css('display', 'none');
                $('.revenues_detail').css('display', '');
                $('.withheld_tax_detail').css('display', 'none');
                $('.unspecified_detail').css('display', 'none');
            } else if (type == 'withheld_tax') {
                $('.expenses_detail').css('display', 'none');
                $('.revenues_detail').css('display', 'none');
                $('.withheld_tax_detail').css('display', '');
                $('.unspecified_detail').css('display', 'none');
            } else {
                $('.expenses_detail').css('display', 'none');
                $('.revenues_detail').css('display', 'none');
                $('.withheld_tax_detail').css('display', 'none');
                $('.unspecified_detail').css('display', '');
            }
        }
    </script>
@endpush

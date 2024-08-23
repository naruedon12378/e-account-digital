<form id="form">
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.edit') }}</h5>
                    <div class="ml-3">
                        <div class="icheck-primary icheck-inline">
                            <input type="radio" name="etype_form" id="ebasic_form" value="basic" checked />
                            <label for="ebasic_form">{{ __('product.basic') }}</label>
                        </div>
                        <div class="icheck-primary icheck-inline">
                            <input type="radio" name="etype_form" id="eadvance_form" value="advance" />
                            <label for="eadvance_form">{{ __('product.advance') }}</label>
                        </div>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eid">
                    <div class="mb-3">
                        <label class="form-label">{{ __('payroll_department.department_name_th') }}</label>
                        <input class="form-control " name="ename_th" id="ename_th" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('payroll_department.department_name_en') }}</label>
                        <input class="form-control " name="ename_en" id="ename_en" />
                    </div>

                    <div class="advance_form" style="display: none;">
                        <div class="mb-3">
                            <label
                                class="form-label">{{ __('payroll_department.adjust_salary_to_account_code') }}</label>
                            <select name="eaccount" id="eaccount" class="form-control select2" style="width: 100%">
                                <option>{{ __('payroll_department.not_specified') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="close-modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="updateData()">{{ __('home.save') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        $(document).ready(function() {});

        $("input[name='etype_form']").on('change', function() {
            echkFormType();
        });

        function echkFormType() {
            type = $("input[name='etype_form']:checked").val();
            if (type == 'advance') {
                $('.advance_form').css('display', '');
            } else {
                $('.advance_form').css('display', 'none');
            }
        }
    </script>
@endpush

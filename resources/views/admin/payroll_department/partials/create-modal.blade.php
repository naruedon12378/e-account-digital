<form id="form">
    <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.add') }}</h5>
                    <div class="ml-3">
                        <div class="icheck-primary icheck-inline">
                            <input type="radio" name="type_form" id="basic_form" value="basic" checked />
                            <label for="basic_form">{{ __('product.basic') }}</label>
                        </div>
                        <div class="icheck-primary icheck-inline">
                            <input type="radio" name="type_form" id="advance_form" value="advance" />
                            <label for="advance_form">{{ __('product.advance') }}</label>
                        </div>
                    </div>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('payroll_department.department_name_th') }}</label>
                        <input class="form-control " name="name_th" id="name_th" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('payroll_department.department_name_en') }}</label>
                        <input class="form-control " name="name_en" id="name_en" />
                    </div>

                    <div class="advance_form" style="display: none;">
                        <div class="mb-3">
                            <label
                                class="form-label">{{ __('payroll_department.adjust_salary_to_account_code') }}</label>
                            <select name="cost_method" id="cost_method" class="form-control select2"
                                style="width: 100%">
                                <option>{{ __('payroll_department.not_specified') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="close-modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="storeData()">{{ __('home.ok') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        $(document).ready(function() {});

        $("input[name='type_form']").on('change', function() {
            chkFormType();
        });

        function chkFormType() {
            type = $("input[name='type_form']:checked").val();
            if (type == 'advance') {
                $('.advance_form').css('display', '');
            } else {
                $('.advance_form').css('display', 'none');
            }
        }
    </script>
@endpush

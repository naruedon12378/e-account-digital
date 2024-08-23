<form id="form">
    <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('payroll_salary_summary.modal_header') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <div class="col-6">
                            <label class="form-label">{{ __('payroll_salary_summary.from_date') }}</label>
                            <input type="text" class="form-control  inputmask-date datepicker" id="from_date"
                                name="from_date">
                        </div>
                        <div class="col-6">
                            <label class="form-label">{{ __('payroll_salary_summary.to_date') }}</label>
                            <input type="text" class="form-control  inputmask-date datepicker" id="to_date"
                                name="to_date">
                        </div>
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
                    <a class="btn btn-danger" onclick="resetModal()">{{ __('home.reset') }}</a>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="storeData()">{{ __('home.ok') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush

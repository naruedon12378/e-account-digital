<form id="form">
    <div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
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
                    <button type="button" id="close-modal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" id="id" class="form-control">
                        {{-- <div class="col-3 offset-9">
                            <input type="text" name="code" id="code" class="form-control">
                        </div> --}}
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                                    {{ __('payroll_financial_record.account_type') }}
                                </blockquote>
                            </div>

                            <div class="mb-3">
                                <div class="icheck-primary icheck-inline">
                                    <input type="radio" name="account_type" id="acc_type_revenue"
                                        value="{{ App\Models\PayrollFinancialRecord::REVENUE }}" checked />
                                    <label for="acc_type_revenue">{{ __('payroll_financial_record.revenue') }}</label>
                                </div>
                                <div class="icheck-primary icheck-inline">
                                    <input type="radio" name="account_type" id="acc_type_deduct"
                                        value="{{ App\Models\PayrollFinancialRecord::DEDUCT }}" />
                                    <label for="acc_type_deduct">{{ __('payroll_financial_record.deduct') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                                    {{ __('payroll_financial_record.type') }}
                                </blockquote>
                            </div>

                            <div class="mb-3">
                                <div class="icheck-primary icheck-inline">
                                    <input type="radio" name="type" id="type_regular"
                                        value="{{ App\Models\PayrollFinancialRecord::REGULAR }}" checked />
                                    <label for="type_regular">{{ __('payroll_financial_record.regular') }}</label>
                                </div>
                                <div class="icheck-primary icheck-inline">
                                    <input type="radio" name="type" id="type_irregular"
                                        value="{{ App\Models\PayrollFinancialRecord::IRREGULAR }}" />
                                    <label for="type_irregular">{{ __('payroll_financial_record.irregular') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('payroll_financial_record.name_th') }}</label>
                        <input class="form-control " name="name_th" id="name_th" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('payroll_financial_record.name_en') }}</label>
                        <input class="form-control " name="name_en" id="name_en" />
                    </div>

                    <div class="advance_form" style="display: none;">
                        <div class="mb-3">
                            <label
                                class="form-label">{{ __('payroll_financial_record.account_code_for_this_item') }}</label>
                            <select name="account" id="account" class="form-control select2" style="width: 100%">
                                <option value="">{{ __('payroll_financial_record.include_in_salary') }}</option>
                                @foreach ($account_types as $type)
                                    <option value="{{ $type->id }}">
                                        @if ($locale == 'th')
                                            {{ $type->account_code }} - {{ $type->name_th }}
                                        @else
                                            {{ $type->account_code }} - {{ $type->name_en }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="advance_form" style="display: none;">
                        <div class="mb-3">
                            <label
                                class="form-label">{{ __('payroll_financial_record.annual_taxable_revenue') }}</label>
                            <select name="annual_revenue" id="annual_revenue" class="form-control select2"
                                style="width: 100%">
                                <option value="{{ App\Models\PayrollFinancialRecord::ANNUAL_REVENUE_INCLUDE }}">
                                    {{ __('payroll_financial_record.include_in_this_item') }}</option>
                                <option value="{{ App\Models\PayrollFinancialRecord::ANNUAL_REVENUE_EXCLUDE }}"">
                                    {{ __('payroll_financial_record.exclude_this_item') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="advance_form" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">{{ __('payroll_financial_record.ssc_base_salary') }}</label>
                            <select name="ssc_base_salary" id="ssc_base_salary" class="form-control select2"
                                style="width: 100%">
                                <option value="{{ App\Models\PayrollFinancialRecord::SSC_BASE_SALARY_INCLUDE }}">
                                    {{ __('payroll_financial_record.include_in_this_item') }}</option>
                                <option value="{{ App\Models\PayrollFinancialRecord::SSC_BASE_SALARY_EXCLUDE }}"">
                                    {{ __('payroll_financial_record.exclude_this_item') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn-reset btn btn-danger" onclick="resetModal()"
                        hidden>{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="storeData()">{{ __('home.save') }}</a>
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
    </script>
@endpush

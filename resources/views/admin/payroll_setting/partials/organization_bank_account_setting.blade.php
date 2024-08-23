<div class="card shadow-custom">
    <div class="card-header" style="border-bottom: none;">
        <button type="button" class="btn btn-tool float-right mt-1" data-card-widget="collapse">
            {{ __('payroll_setting.show_less') }}
        </button>
        <blockquote class="quote-success text-md" style="margin: 0 !important;">
            {{ __('payroll_setting.organization_bank_account') }}
        </blockquote>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.bank_account_for_pay_run') }}</label>
                    <select name="paid_salary_account_id" id="paid_salary_account_id" class="form-control select2"
                        style="width: 100%;">
                        @foreach ($banks as $bank)
                            @php
                                if ($bank->bank_id != null) {
                                    $name =
                                        $bank->bank->$name .
                                        ' : ' .
                                        $bank->account_number .
                                        ' - ' .
                                        $bank->account_name;
                                } else {
                                    $name = $bank->account_name;
                                }
                            @endphp
                            <option value="{{ $bank->id }}"
                                {{ $data->paid_salary_account_id == $bank->id ? 'selected' : '' }}>{{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.pay_run_date') }}</label>
                    <select name="day_of_paid_salary" id="day_of_paid_salary" class="form-control select2"
                        style="width: 100%;">
                        @for ($i = 1; $i <= 28; $i++)
                            <option>{{ $i }}</option>
                        @endfor
                        <option value="0">{{ __('payroll_setting.end_of_month') }}</option>
                    </select>
                </div>
            </div>
        </div>

    </div>
</div>

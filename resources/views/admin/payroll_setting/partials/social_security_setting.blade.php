<div class="card shadow-custom">
    <div class="card-header" style="border-bottom: none;">
        <button type="button" class="btn btn-tool float-right mt-1" data-card-widget="collapse">
            {{ __('payroll_setting.show_less') }}
        </button>
        <blockquote class="quote-success text-md" style="margin: 0 !important;">
            {{ __('payroll_setting.social_security') }}
        </blockquote>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <label for="" class="w-100">{{ __('payroll_setting.register_social_security') }}</label>
                <div class="icheck-primary icheck-inline mb-3">
                    <input type="radio" name="social_security_status" id="registered_chkbox"
                        {{ $data->social_security_status == 1 ? 'checked' : '' }} value="1" />
                    <label for="registered_chkbox">{{ __('payroll_setting.registered') }}</label>
                </div>
                <div class="icheck-primary icheck-inline mb-3">
                    <input type="radio" name="social_security_status" id="not_registered_chkbox"
                        {{ $data->social_security_status == 0 ? 'checked' : '' }} value="0" />
                    <label for="not_registered_chkbox">{{ __('payroll_setting.not_registered') }}</label>
                </div>
            </div>
            <div class="col-sm-12 social-security-section mb-2" style="display: none;">
                <label for="social_security_id" class="w-100">{{ __('payroll_setting.social_security_id') }}</label>
                <input type="text" class="form-control" name="social_security_id" id="social_security_id"
                    maxlength="10" value="{{ @$data->social_security_id }}">
                <div class="icheck-primary icheck-inline my-3">
                    <input type="radio" name="social_security_branch_type" id="social_security_branch_type"
                        {{ $data->social_security_branch_type == 1 ? 'checked' : '' }} value="1" />
                    <label for="social_security_branch_type">{{ __('payroll_setting.head_office') }}</label>
                </div>
                <div class="icheck-primary icheck-inline my-3">
                    <input type="radio" name="social_security_branch_type" id="not_social_security_branch_type"
                        {{ $data->social_security_branch_type == 2 ? 'checked' : '' }} value="2" />
                    <label for="not_social_security_branch_type">{{ __('payroll_setting.branch') }}</label>
                </div>
                <input type="text" name="social_security_branch_id" id="social_security_branch_id"
                    class="form-control" maxlength="6" value="{{ @$data->social_security_branch_id }}"
                    style="display: none;">
            </div>
            <div class="col-sm-6 social-security-section mb-2" style="display: none;">
                <label for="employers_social_security_rate"
                    class="w-100">{{ __('payroll_setting.employers_social_security_rate') }}</label>
                <input type="number" class="form-control" name="employers_social_security_rate"
                    id="employers_social_security_rate" max="5"
                    value="{{ @$data->employers_social_security_rate }}">
            </div>
            <div class="col-sm-6 social-security-section mb-2" style="display: none;">
                <label for="employers_maximum_amount"
                    class="w-100">{{ __('payroll_setting.employees_maximum_amount') }}</label>
                <input type="number" class="form-control" name="employers_maximum_amount" id="employers_maximum_amount"
                    max="750" value="{{ @$data->employers_maximum_amount }}">
            </div>
            <div class="col-sm-6 social-security-section mb-2" style="display: none;">
                <label for="employees_social_security_rate"
                    class="w-100">{{ __('payroll_setting.employees_social_security_rate') }}</label>
                <input type="number" class="form-control" name="employees_social_security_rate"
                    id="employees_social_security_rate" max="5"
                    value="{{ @$data->employees_social_security_rate }}">
            </div>
            <div class="col-sm-6 social-security-section mb-2" style="display: none;">
                <label for="employees_maximum_amount"
                    class="w-100">{{ __('payroll_setting.employees_maximum_amount') }}</label>
                <input type="number" class="form-control" name="employees_maximum_amount" id="employees_maximum_amount"
                    max="750" value="{{ @$data->employees_maximum_amount }}">
            </div>
        </div>
    </div>
</div>

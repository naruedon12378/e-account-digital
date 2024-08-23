<div class="card shadow-custom">
    <div class="card-header" style="border-bottom: none;">
        <button type="button" class="btn btn-tool float-right mt-1" data-card-widget="collapse">
            {{ __('payroll_setting.show_less') }}
        </button>
        <blockquote class="quote-success text-md" style="margin: 0 !important;">
            {{ __('payroll_setting.vat') }}
        </blockquote>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="icheck-primary icheck-inline mb-3">
                    <input type="radio" name="vat_status" value="1" id="registered_chkbox"
                        {{ $data->vat_status == 1 ? 'checked' : '' }} />
                    <label for="registered_chkbox">{{ __('payroll_setting.vat_registered') }}</label>
                </div>
                <div class="icheck-primary icheck-inline mb-3">
                    <input type="radio" name="vat_status" value="0" id="not_registered_chkbox"
                        {{ $data->vat_status == 0 ? 'checked' : '' }} />
                    <label for="not_registered_chkbox">{{ __('payroll_setting.vat_not_registered') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>

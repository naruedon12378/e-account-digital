<div class="card shadow-custom">
    <div class="card-header" style="border-bottom: none;">
        <button type="button" class="btn btn-tool float-right mt-1" data-card-widget="collapse">
            {{ __('payroll_setting.show_less') }}
        </button>
        <blockquote class="quote-success text-md" style="margin: 0 !important;">
            {{ __('payroll_setting.pvd') }}
        </blockquote>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <label for="" class="w-100">{{ __('payroll_setting.register_pvd') }}</label>
                <div class="icheck-primary icheck-inline mb-3">
                    <input type="radio" name="pvd_status" id="pvd_register"
                        {{ $data->pvd_status == 1 ? 'checked' : '' }} value="1" />
                    <label for="pvd_register">{{ __('home.yes') }}</label>
                </div>
                <div class="icheck-primary icheck-inline mb-3">
                    <input type="radio" name="pvd_status" id="not_pvd_register"
                        {{ $data->pvd_status == 0 ? 'checked' : '' }} value="0" />
                    <label for="not_pvd_register">{{ __('home.no') }}</label>
                </div>
            </div>
            <div class="col-sm-6 pvd-section mb-2" style="display: none;">
                <label for="pvd_rate" class="w-100">{{ __('payroll_setting.pvd_rate') }}</label>
                <input type="number" class="form-control" name="pvd_rate" id="pvd_rate" max="15"
                    value="{{ @$data->pvd_rate }}">
            </div>
        </div>
    </div>
</div>

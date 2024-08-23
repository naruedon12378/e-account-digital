<div class="modal fade" id="addAccountModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="frmAccount">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.add') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            @include('vendor.adminlte.components.form.form-select', [
                                'name' => 'primary_account_id',
                                'label' => __('chart_of_account.primary_account'),
                                'isRequired' => true,
                                'property' => '',
                                'data' => $primaries->pluck('local_name', 'id'),
                                'value' => null,
                                'class' => null,
                            ])
                        </div>
                        <div class="col-12 col-md-6">
                            @include('vendor.adminlte.components.form.form-select', [
                                'name' => 'secondary_account_id',
                                'label' => __('chart_of_account.secondary_account'),
                                'isRequired' => true,
                                'property' => '',
                                'data' => [],
                                'value' => null,
                                'class' => null,
                            ])
                        </div>
                        <div class="col-12 col-md-6">
                            @include('vendor.adminlte.components.form.form-select', [
                                'name' => 'sub_account_id',
                                'label' => __('chart_of_account.sub_account'),
                                'isRequired' => true,
                                'property' => '',
                                'data' => [],
                                'value' => null,
                                'class' => null,
                            ])
                        </div>
                        <div class="col-12 col-md-6">
                            @include('vendor.adminlte.components.form.form-group', [
                                'name' => 'account_code',
                                'label' => 'chart_of_account.account_code',
                                'type' => 'text',
                                'isRequired' => true,
                                'property' => '',
                                'value' => null,
                            ])
                        </div>
                        <div class="col-12 col-md-6">
                            @include('vendor.adminlte.components.form.form-group', [
                                'name' => 'name_th',
                                'label' => 'chart_of_account.account_name_th',
                                'type' => 'text',
                                'isRequired' => true,
                                'property' => '',
                                'value' => null,
                            ])
                        </div>
                        <div class="col-12 col-md-6">
                            @include('vendor.adminlte.components.form.form-group', [
                                'name' => 'name_en',
                                'label' => 'chart_of_account.account_name_en',
                                'type' => 'text',
                                'isRequired' => true,
                                'property' => '',
                                'value' => null,
                            ])
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label class="form-label"
                                    for="description">{{ __('chart_of_account.account_description') }}</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            @include('vendor.adminlte.components.form.form-select', [
                                'name' => 'income_tax_id',
                                'label' => __('chart_of_account.income_tax_rate'),
                                'isRequired' => false,
                                'property' => '',
                                'data' => [],
                                'value' => null,
                                'class' => null,
                            ])
                        </div>
                        <div class="col-12 col-md-6">
                            @include('vendor.adminlte.components.form.form-select', [
                                'name' => 'with_holding_tax_id',
                                'label' => __('chart_of_account.withholding_tax_rate'),
                                'isRequired' => false,
                                'property' => '',
                                'data' => [],
                                'value' => null,
                                'class' => null,
                            ])
                        </div>
                    </div>
                </div>

                <input type="hidden" id="id" name="id">
                <input type="hidden" id="primary_prefix" name="primary_prefix">
                <input type="hidden" id="secondary_prefix" name="secondary_prefix">
                <input type="hidden" id="sub_prefix" name="sub_prefix">
                <input type="hidden" id="running_number" name="running_number">

                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger">{{ __('home.reset') }}</button>
                    <button type="button" class="btn btn-outline-secondary px-5"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="button" id="btnSubmit"
                        class="btn btn-outline-primary px-5">{{ __('home.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

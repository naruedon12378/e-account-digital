<form id="form">
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.add') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="eid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                                    {{ __('inventory.inventory_information') }}
                                </blockquote>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                @include('vendor.adminlte.components.form.form-select', [
                                    'name' => 'ewarehouse_id',
                                    'label' => 'inventory.warehouse',
                                    'isRequired' => true,
                                    'property' => '',
                                    'data' => $warehouses->pluck('name', 'id'),
                                    'value' => null,
                                    'class' => null,
                                ])
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                @include('vendor.adminlte.components.form.form-select', [
                                    'name' => 'eproduct_id',
                                    'label' => 'inventory.product',
                                    'isRequired' => true,
                                    'property' => '',
                                    'data' => $products->pluck('name_th', 'id'),
                                    'value' => null,
                                    'class' => null,
                                ])
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory.amount') }}</label>
                                <input type="number" class="form-control " name="eamount" id="eamount" min="0"
                                    placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory.limit_amount_notification') }}</label>
                                <input type="number" class="form-control " name="elimit_amount_notification"
                                    id="elimit_amount_notification" min="0" placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory.limit_min_amount') }}</label>
                                <input type="number" class="form-control " name="elimit_min_amount"
                                    id="elimit_min_amount" min="0" placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory.limit_max_amount') }}</label>
                                <input type="number" class="form-control " name="elimit_max_amount"
                                    id="elimit_max_amount" min="0" placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory.location') }}</label>
                                <input type="text" class="form-control " name="elocation" id="elocation" />
                            </div>
                        </div>
                        <div class="col-sm-6"><br>
                            <div class="mb-3">
                                <label class="form-label">{{ __('home.publish') }}</label>
                                <div class="pl-2 d-inline-block">
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" name="eis_active" id="eishold_true" value="onhold" />
                                        <label for="eishold_true">{{ __('inventory.onhold') }}</label>
                                    </div>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" name="eis_active" id="eisactive_true" value="active" />
                                        <label for="eisactive_true">{{ __('home.active') }}</label>
                                    </div>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" name="eis_active" id="eisactive_false" value="inactive" />
                                        <label for="eisactive_false">{{ __('home.not_active') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
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
    </script>
@endpush

<form id="form">
    <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-sl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        {{ __('inventory_stock_adjust.inventory_stock_adjust') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                                    {{ __('inventory_stock_adjust.inventory_stock_adjust_information') }}
                                </blockquote>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                @include('vendor.adminlte.components.form.form-select', [
                                    'name' => 'inventory_stock_id',
                                    'label' => 'inventory_stock.inventory',
                                    'isRequired' => true,
                                    'property' => '',
                                    'data' => $inventorystockOption,
                                    'value' => null,
                                    'class' => null,
                                ])
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory_stock_adjust.amount') }}</label>
                                <input type="number" class="form-control " name="amount" id="amount" min="0"
                                    placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory_stock.remark') }}</label>
                                <textarea class="form-control" name="remark" id="remark" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="storeData()">{{ __('home.save') }}</a>
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

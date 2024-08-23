<form id="form">
    <div class="modal fade" id="modal-edit" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('inventory_stock.add_inventory_stock') }}
                    </h5>
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
                                    {{ __('inventory_stock.inventory_stock_data') }}
                                </blockquote>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                @include('vendor.adminlte.components.form.form-select', [
                                    'name' => 'einventory_id',
                                    'label' => 'inventory_stock.inventory',
                                    'isRequired' => true,
                                    'property' => '',
                                    'data' => $inventoryOptions,
                                    'value' => null,
                                    'class' => null,
                                ])
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                @include('vendor.adminlte.components.form.form-select', [
                                    'name' => 'eorder_id',
                                    'label' => 'inventory_stock.order',
                                    'isRequired' => true,
                                    'property' => '',
                                    'data' => $orders->pluck('doc_number', 'id'),
                                    'value' => null,
                                    'class' => null,
                                ])
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label class="mb-1" for="transaction">{{ __('inventory_stock.transaction') }}
                                        <span class="text-danger"> *</span></label>
                                    <select class="form-control" name="transaction" id="etransaction">
                                        <option value="" selected disabled>{{ __('home.please_select') }}</option>
                                        <option value="adjustment" data-transaction="0">Adjustment</option>
                                        <option value="quotation" data-transaction="0">Quotation</option>
                                        <option value="beginning_balance" data-transaction="0">Beginning Balance
                                        </option>
                                        <option value="issue_requisition" data-transaction="0">Issue Requisition
                                        </option>
                                        <option value="reture_issue_stock" data-transaction="0">Reture Issue Stock
                                        </option>
                                        <option value="receipt_planning" data-transaction="0">Receipt Planning</option>
                                        <option value="receive_finish_stock" data-transaction="0">Receive Finish Stock
                                        </option>
                                        <option value="transfer_requistion" data-transaction="0">Transfer Requistion
                                        </option>
                                    </select>
                                    <span class="text-danger invalid transaction"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory_stock.lot_number') }}</label>
                                <input type="number" class="form-control " name="lot_number" id="elot_number"
                                    min="0" placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory_stock.add_amount') }}</label>
                                <input type="number" class="form-control " name="add_amount" id="eadd_amount"
                                    min="0" placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory_stock.used_amount') }}</label>
                                <input type="number" class="form-control " name="used_amount" id="eused_amount"
                                    min="0" placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory_stock.remaining_amount') }}</label>
                                <input type="number" class="form-control " name="remaining_amount"
                                    id="eremaining_amount" min="0" placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory_stock.coust_price') }}</label>
                                <input type="number" class="form-control " name="coust_price" id="ecoust_price"
                                    min="0" placeholder="0" />
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">{{ __('inventory_stock.remark') }}</label>
                                <textarea class="form-control" name="remark" id="eremark" rows="3"></textarea>
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

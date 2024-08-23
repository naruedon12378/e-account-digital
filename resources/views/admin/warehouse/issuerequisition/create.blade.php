@extends('adminlte::page')
@php($pagename = 'Issue Requisition')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>
@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    <x-form-card>
        <x-form name="frmPurchase"
            :action="$issueRequisition->id ? route('issuerequisition.update', $issueRequisition->id) : route('issuerequisition.store')" enctype>
            @if ($issueRequisition->id)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $issueRequisition->id }}">
            @endif
            <div class="border-bottom border-success px-3 pt-3">
                <div class="d-flex justify-content-between flex-wrap">
                    <h4>Create Issue Requisition</h4>
                    <x-form-group label="beginning_balance.code" name="code" required
                        value="{{ $issueRequisition->code }}">
                    </x-form-group>
                </div>
            </div>
            <x-warehouse.collapse number="1" title="Seller" show>
                <div class="row">
                    <div class="col-12 col-md-6">
                        @if($issueRequisition && $issueRequisition->id && $issueRequisition->company_id)
                            <x-warehouse.form-select label="{{ __('beginning_balance.company') }}" :selectoption="'beginning_balance.select_company'"
                                name="company_id" class="select2" required :value="$companies" :selectedvalue="$issueRequisition->company_id"
                                :data="contacts()"></x-warehouse.form-select>
                        @else
                            <x-warehouse.form-select label="{{ __('beginning_balance.company') }}" :selectoption="'beginning_balance.select_company'"
                                name="company_id" class="select2" required :value="$companies" :selectedvalue="''"
                                :data="contacts()"></x-warehouse.form-select>
                        @endif
                    </div>
                    <div class="col-12 col-md-3">
                        <x-datepicker label="beginning_balance.created_at" name="created_at" :value="$issueRequisition->created_at" required>
                        </x-datepicker>
                    </div>
                </div>
            </x-warehouse.collapse>
            <x-warehouse.collapse number="3" title="Pricing and tax setting" show>
                <div class="row">
                    <div class="col-12 col-md-4">
                        @if($issueRequisition && $issueRequisition->id)
                            <x-form-select label="beginning_balance.issue-requisition_status" name="status"  class="select2" required
                                :value="$issueRequisition->status" :data="$status"></x-form-select>
                        @else
                            <x-warehouse.status-form-select label="beginning_balance.issue-requisition_status" name="status" :selectoption="'beginning_balance.please_select_status'" :selectedvalued="'pending'" class="select2" required
                                :value="'pending'" :data="$status"></x-warehouse.status-form-select>
                        @endif
                    </div>
                    <div class="col-12 col-md-4">
                        <x-form-select label="beginning_balance.tax_type" name="tax_type" class="select2" required
                            :value="$issueRequisition->status" :data="pricingTypes()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-4">
                        <x-form-select label="beginning_balance.code" name="code" class="select2" required
                            :value="$issueRequisition->code" :data="currencies()"></x-form-select>
                    </div>
                </div>
            </x-warehouse.collapse>
            <x-warehouse.collapse number="4" title="{{ __('beginning_balance.issue-requisition-information')}}" show>
                <x-warehouse.search-product class="mb-3" :selectproduct="'beginning_balance.select_product'"></x-warehouse.search-product>
                <x-items-table></x-items-table>
            </x-warehouse.collapse>
            <x-warehouse.collapse number="5" title="Summary" show>
                <x-item-summary></x-item-summary>
            </x-warehouse.collapse>
            <x-warehouse.collapse number="6" title="Remark for customer" show>
                <x-textarea label="beginning_balance.remark" name="remark" :value="$issueRequisition->remark"></x-textarea>
            </x-warehouse.collapse>
            <div class="text-center mt-5">
                <x-button-cancel url="{{ route('issuerequisition.index') }}">
                    {{ __('file.Back') }}
                </x-button-cancel>
                <x-button>{{ __('file.Submit') }}</x-button>
            </div>

        </x-form>
    </x-form-card>
@endsection
@push('js')
    <script src="{{ asset('js/warehouse/warehouseChargeitem.js') }}"></script>
    <script>
        var alertMessage = "{{ trans('file.Quantity exceeds stock quantity') }}";
        var productList = @json(productList());
        var items = @json(isset($items) ? $items : []);
        if (items.length > 0) {
            items.forEach(product => {
                rowItemTable(product);
            });
        }
        $(document).on('click', '#frmPurchase #btnSubmit', function() {
            console.log(state.items);
            let formData = new FormData($('#frmPurchase')[0]);
            let routeName = $('#frmPurchase').attr('action');
            formData.append('items', JSON.stringify(state.items));
            formData.append('summary', JSON.stringify(state.summary));
            $.ajax({
                type: "POST",
                url: routeName,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    window.location.href = data;
                },
                error: function(message) {
                    $('.invalid').html('');
                    for (const key in message.responseJSON.errors) {
                        if (key.includes('.')) {
                            let val = key.replace(key.slice(-2), '');
                            $('.invalid.' + val).html(message.responseJSON, errors[key]);
                        } else {
                            $('.invalid.' + key).html(message.responseJSON.errors[key]);
                        }
                    }
                }
            });
        });
    </script>
@endpush

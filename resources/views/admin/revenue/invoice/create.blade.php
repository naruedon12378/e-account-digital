@extends('adminlte::page')
@php($pagename = 'Invoice')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>
@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    {!! $invoice->progress_style !!}
    <x-form-card>
        <x-form name="frmInvoice" :action="$invoice->id ? route('invoices.update', $invoice->id) : route('invoices.store')" enctype>

            @if ($invoice->id)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $invoice->id }}">
            @endif

            <div class="border-bottom border-success px-3 pt-3">
                <div class="d-flex justify-content-between flex-wrap">
                    <h4>Create Invoice</h4>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <x-form-group label="invoice.reference" name="reference" value="{{ $invoice->reference }}">
                            </x-form-group>
                        </div>
                        <div class="col-12 col-md-6">
                            <x-form-group label="invoice.doc_number" name="doc_number" required
                                value="{{ $invoice->doc_number }}">
                            </x-form-group>
                        </div>
                    </div>
                </div>
            </div>

            {{-- customer --}}
            <x-collapse number="1" title="Customer" show>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-select label="contact.customer_id" name="customer_id" class="select2" required
                            :value="$invoice->customer_id" :data="contacts()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-3">
                        <x-datepicker label="invoice.issue_date" name="issue_date" :value="$invoice->issue_date" required>
                        </x-datepicker>
                    </div>
                    <div class="col-12 col-md-3">
                        <x-datepicker label="invoice.due_date" name="due_date" :value="$invoice->due_date" required>
                        </x-datepicker>
                    </div>
                    <div class="col-12 col-md-10">
                        <label for="">Address</label>
                        <p id="address"></p>
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="">Tel</label>
                        <p id="phone"></p>
                    </div>
                </div>
            </x-collapse>

            <x-collapse number="2" title="Classification Group" show>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <x-form-select label="invoice.project_id" name="project_id" class="select2" required
                            :value="$invoice->project_id"></x-form-select>
                    </div>
                    <div class="col-12 col-md-4">
                        <x-form-select label="invoice.salesman_id" name="salesman_id" class="select2" required
                            :value="$invoice->salesman_id"></x-form-select>
                    </div>
                    <div class="col-12 col-md-4">
                        <x-form-select label="invoice.business_type" name="business_type" class="select2" required
                            :value="$invoice->business_type"></x-form-select>
                    </div>
                </div>
            </x-collapse>

            <x-collapse number="3" title="Pricing and tax setting" show>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <x-form-select label="invoice.vat_type" name="vat_type" class="select2" required :value="$invoice->vat_type"
                            :data="pricingTypes()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-group">
                            <label for="">Issue Tax Invoice</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1" checked
                                    value="0" style="cursor: pointer;">
                                <label class="custom-control-label text-primary" for="customSwitch1"
                                    style="cursor: pointer;">Tax Invoice</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <x-form-select label="invoice.currency_code" name="currency_code" class="select2" required
                            :value="$invoice->currency_code" :data="currencies()"></x-form-select>
                    </div>
                </div>
            </x-collapse>

            <x-collapse number="4" title="Item" show>
                <x-search-product class="mb-3"></x-search-product>
                <x-items-table></x-items-table>
            </x-collapse>

            <x-collapse number="5" title="Summary" show>
                <x-item-summary></x-item-summary>
            </x-collapse>

            <x-collapse number="6" title="Remark for customer" show>
                <x-textarea label="invoice.remark" name="remark" :value="$invoice->remark"></x-textarea>
            </x-collapse>

            <x-collapse number="7" title="Attach file to document" show>
            </x-collapse>

            <div class="text-center mt-5">
                <x-button-cancel url="{{ route('invoices.index') }}">
                    {{ __('file.Back') }}
                </x-button-cancel>
                <x-button>{{ __('file.Submit') }}</x-button>
            </div>

        </x-form>
    </x-form-card>
@endsection

@push('js')
    <script src="{{ asset('js/admin/chargeitem.js') }}"></script>
    <script>
        var alertMessage = "{{ trans('file.Quantity exceeds stock quantity') }}";
        var productList = @json(productList());
        var items = @json(isset($items) ? $items : []);
        if (items.length > 0) {
            items.forEach(product => {
                rowItemTable(product);
            });
        }

        // submit form
        $(document).on('click', '#frmInvoice #btnSubmit', function() {
            let formData = new FormData($('#frmInvoice')[0]);
            let routeName = $('#frmInvoice').attr('action');
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

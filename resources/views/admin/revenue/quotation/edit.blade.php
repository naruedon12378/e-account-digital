@extends('adminlte::page')
@php($pagename = 'Quotation')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    {!! $quotation?->progress_style !!}
    <x-form-card>
        <x-form-tabs :tabs="$tabs">
            <x-tab-content id="home" active>
                <x-form name="frmQuotation" :action="$quotation->id ? route('quotations.update', $quotation->id) : route('quotations.store')" enctype>

                    @if ($quotation->id)
                        @method('PUT')
                        <input type="hidden" name="id" value="{{ $quotation->id }}">
                    @endif

                    <div class="border-bottom border-success px-3 pt-3">
                        <div class="d-flex justify-content-between flex-wrap">
                            <h4>Edit Quotation
                                {!! $quotation->status_style !!}
                            </h4>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <x-form-group label="quotation.reference" name="reference"
                                        value="{{ $quotation->reference }}">
                                    </x-form-group>
                                </div>
                                <div class="col-12 col-md-6">
                                    <x-form-group label="quotation.quotation_number" name="quotation_number" required
                                        value="{{ $quotation->quotation_number }}">
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
                                    :value="$quotation->customer_id" :data="contacts()"></x-form-select>
                            </div>
                            <div class="col-12 col-md-3">
                                <x-datepicker label="quotation.issue_date" name="issue_date" :value="$quotation->issue_date" required>
                                </x-datepicker>
                            </div>
                            <div class="col-12 col-md-3">
                                <x-datepicker label="quotation.expire_date" name="expire_date" :value="$quotation->expire_date" required>
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
                                <x-form-select label="quotation.project_id" name="project_id" class="select2" required
                                    :value="$quotation->project_id"></x-form-select>
                            </div>
                            <div class="col-12 col-md-4">
                                <x-form-select label="quotation.salesman_id" name="salesman_id" class="select2" required
                                    :value="$quotation->salesman_id"></x-form-select>
                            </div>
                            <div class="col-12 col-md-4">
                                <x-form-select label="quotation.business_type" name="business_type" class="select2" required
                                    :value="$quotation->business_type"></x-form-select>
                            </div>
                        </div>
                    </x-collapse>

                    <x-collapse number="3" title="Pricing and tax setting" show>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <x-form-select label="quotation.vat_type" name="vat_type" class="select2" required
                                    :value="$quotation->vat_type" :data="pricingTypes()"></x-form-select>
                            </div>
                            <div class="col-12 col-md-4">
                                <x-form-select label="quotation.currency_code" name="currency_code" class="select2" required
                                    :value="$quotation->currency_code" :data="currencies()"></x-form-select>
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
                        <x-textarea label="quotation.remark" name="remark" :value="$quotation->remark"></x-textarea>
                    </x-collapse>

                    <x-collapse number="7" title="Attach file to document" show>
                    </x-collapse>

                    <div class="text-center mt-5">
                        <x-button-cancel url="{{ route('quotations.index') }}">
                            {{ __('file.Back') }}
                        </x-button-cancel>
                        <x-button>{{ __('file.Submit') }}</x-button>
                    </div>

                </x-form>
            </x-tab-content>
            <x-tab-content id="history">
                <x-history :doc="$quotation->quotation_number" :histories="$histories"></x-history>
            </x-tab-content>
        </x-form-tabs>
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
        $(document).on('click', '#frmQuotation #btnSubmit', function() {
            let formData = new FormData($('#frmQuotation')[0]);
            let routeName = $('#frmQuotation').attr('action');
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

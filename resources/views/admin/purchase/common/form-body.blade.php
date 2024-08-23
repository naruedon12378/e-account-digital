<x-collapse number="1" title="Seller" show>
    <div class="row">
        <div class="col-12 col-md-6">
            <x-form-select label="purchase.seller_id" name="seller_id" class="select2" required :value="$purchase->seller_id"
                :data="contacts()"></x-form-select>
        </div>
        <div class="col-12 col-md-3">
            <x-datepicker label="purchase.issue_date" name="issue_date" :value="$purchase->issue_date" required>
            </x-datepicker>
        </div>
        <div class="col-12 col-md-3">
            <x-datepicker label="purchase.due_date" name="due_date" :value="$purchase->due_date" required>
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
            <x-form-select label="purchase.project_id" name="project_id" class="select2"
                :value="$purchase->project_id"></x-form-select>
        </div>
        <div class="col-12 col-md-4">
            <x-form-select label="purchase.business_type" name="business_type" class="select2"
                :value="$purchase->business_type"></x-form-select>
        </div>
    </div>
</x-collapse>

<x-collapse number="3" title="Pricing and tax setting" show>
    <div class="row">
        <div class="col-12 col-md-4">
            <x-form-select label="purchase.vat_type" name="vat_type" class="select2" required :value="$purchase->vat_type"
                :data="pricingTypes()"></x-form-select>
        </div>
        <div class="col-12 col-md-4">
            <x-form-select label="purchase.currency_code" name="currency_code" class="select2" required :value="$purchase->currency_code"
                :data="currencies()"></x-form-select>
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

@if($purchase?->is_payment)
    <x-collapse number="6" title="Payment" show>
        @include('admin.purchase.payment.payment-form')
    </x-collapse>
@endif

<x-collapse number="7" title="Remark for seller" show>
    <x-textarea label="purchase.remark" name="remark" :value="$purchase->remark"></x-textarea>
</x-collapse>

<x-collapse number="8" title="Attach file to document" show>
</x-collapse>

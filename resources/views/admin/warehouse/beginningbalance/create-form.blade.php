<x-form name="frmPurchase" :action="$beginningBalance->id
    ? route('beginningbalance.update', $beginningBalance->id)
    : route('beginningbalance.store')" enctype>
    @if ($beginningBalance->id)
        @method('PUT')
        <input type="hidden" name="id" value="{{ $beginningBalance->id }}">
    @endif
    <div class="border-bottom border-success px-3 pt-3">
        <div class="d-flex justify-content-between flex-wrap">
            <h4>Create Beginning Balance</h4>
            <x-form-group label="beginning_balance.code" name="code" required value="{{ $beginningBalance->code }}">
            </x-form-group>
        </div>
    </div>
    <x-warehouse.collapse number="1" title="Seller" show>
        <div class="row">
            <div class="col-12 col-md-6">
                @if($beginningBalance && $beginningBalance->id && $beginningBalance->company_id)
                    <x-warehouse.form-select label="{{ __('beginning_balance.company') }}" :selectoption="'beginning_balance.select_company'"
                        name="company_id" class="select2" required :value="$companies" :selectedvalue="$beginningBalance->company_id"
                        :data="contacts()"></x-warehouse.form-select>
                @else
                    <x-warehouse.form-select label="{{ __('beginning_balance.company') }}" :selectoption="'beginning_balance.select_company'"
                        name="company_id" class="select2" required :value="$companies" :selectedvalue="''"
                        :data="contacts()"></x-warehouse.form-select>
                @endif
            </div>
            <div class="col-12 col-md-3">
                <x-datepicker label="beginning_balance.created_at" name="created_date" :value="$beginningBalance->created_date" required>
                </x-datepicker>
            </div>
        </div>
    </x-warehouse.collapse>
    <x-warehouse.collapse number="3" title="Pricing and tax setting" show>
        <div class="row">
            <div class="col-12 col-md-4">
                @if ($beginningBalance && $beginningBalance->id)
                    <x-form-select label="beginning_balance.beginning_balance_status" name="status" class="select2"
                        required :value="$beginningBalance->status" :data="$status"></x-form-select>
                @else
                    <x-warehouse.status-form-select label="beginning_balance.beginning_balance_status" name="status"
                        :selectoption="'beginning_balance.please_select_status'" :selectedvalued="'pending'" class="select2" required :value="$beginningBalance->status"
                        :data="$status"></x-warehouse.status-form-select>
                @endif
            </div>
            <div class="col-12 col-md-4">
                <x-form-select label="beginning_balance.tax_type" name="tax_type" class="select2" required
                    :value="$beginningBalance->status" :data="pricingTypes()"></x-form-select>
            </div>
            <div class="col-12 col-md-4">
                <x-form-select label="beginning_balance.currency_type" name="currency_code" class="select2" required
                    :value="$beginningBalance->code" :data="currencies()"></x-form-select>
            </div>
        </div>
    </x-warehouse.collapse>
    <x-warehouse.collapse number="4" title="{{ __('beginning_balance.beginning_balance') }}" show>
        <x-warehouse.search-product class="mb-3" :selectproduct="'beginning_balance.select_product'"></x-warehouse.search-product>
        <x-items-table></x-items-table>
    </x-warehouse.collapse>
    <x-warehouse.collapse number="5" title="Summary" show>
        <x-item-summary></x-item-summary>
    </x-warehouse.collapse>
    <x-warehouse.collapse number="6" title="Remark for customer" show>
        <x-textarea label="beginning_balance.remark" name="remark" :value="$beginningBalance->remark"></x-textarea>
    </x-warehouse.collapse>
    <div class="text-center mt-5">
        <x-button-cancel url="{{ route('beginningbalance.index') }}">
            {{ __('file.Back') }}
        </x-button-cancel>
        <x-button>{{ __('file.Submit') }}</x-button>
    </div>
</x-form>

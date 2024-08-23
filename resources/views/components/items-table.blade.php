<style>
    #itemTable td {
        padding: 0 0.4rem 0 0.4rem;
    }
</style>
<div class="table-responsive border-top">
    <table id="itemTable" class="table table-bordered">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="35%">Product/Service</th>
                <th width="5%">Account</th>
                <th class="text-right" width="5%">Quantity</th>
                <th class="text-right" width="10%">Price/Q</th>
                <th class="text-right" width="5%">Disc./Q</th>
                <th class="text-right" width="10%">VAT</th>
                <th class="text-right" width="15%">Pre-VAT Amount</th>
                <th class="text-right" width="10%">WHT</th>
                <th class="text-center" width="2%">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<x-modal name="editModal" autoClose>
    <div class="row">
        <div class="col-12 col-md-6">
            <x-form-group label="quotation.price" name="price" type="number">
            </x-form-group>
        </div>
        <div class="col-12 col-md-6">
            <x-form-group label="quotation.discount" name="discount" type="number">
            </x-form-group>
        </div>
        <div class="col-12 col-md-6">
            <x-form-select label="quotation.vat_rate" name="vat_rate" :data="getVatRate()"></x-form-select>
        </div>
        <div class="col-12 col-md-6">
            <x-form-select label="quotation.wht_rate" name="wht_rate" :data="getWhtRate()"></x-form-select>
        </div>
        <div class="col-12">
            <x-form-select label="quotation.account" name="account" :data="getAccountCodes([4])"></x-form-select>
        </div>
        <div class="col-12">
            <div class="form-group mb-3">
                <x-textarea label="quotation.description" name="description"></x-textarea>
            </div>
        </div>
    </div>
</x-modal>
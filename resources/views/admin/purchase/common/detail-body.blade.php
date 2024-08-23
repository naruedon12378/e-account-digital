<x-collapse number="1" title="Seller" show>
    <x-template.list-group>
        <x-template.list-item>
            <div class="row">
                <div class="col-4 col-md-2">
                    <x-template.list-item-label label="Seller">
                    </x-template.list-item-label>
                </div>
                <div class="col-8 col-md-10">
                    {{ businessParties()['name'] }}
                </div>
            </div>
        </x-template.list-item>
        <x-template.list-item>
            <div class="row">
                <div class="col-4 col-md-2">
                    <x-template.list-item-label label="Address">
                    </x-template.list-item-label>
                </div>
                <div class="col-8 col-md-10">
                    {{ businessParties()['address'] }}
                </div>
            </div>
        </x-template.list-item>
        <x-template.list-item>
            <div class="row">
                <div class="col-4 col-md-2">
                    <x-template.list-item-label label="Issue Date">
                    </x-template.list-item-label>
                </div>
                <div class="col-8 col-md-10">
                    {{ date('Y-m-d') }}
                </div>
            </div>
        </x-template.list-item>
        <x-template.list-item>
            <div class="row">
                <div class="col-4 col-md-2">
                    <x-template.list-item-label label="Due Date">
                    </x-template.list-item-label>
                </div>
                <div class="col-8 col-md-10">
                    {{ date('Y-m-d') }}
                </div>
            </div>
        </x-template.list-item>
    </x-template.list-group>
</x-collapse>

<x-collapse number="2" title="Classification Group" show>
    <x-template.list-group>
        <x-template.list-item>
            <div class="row">
                <div class="col-4 col-md-2">
                    <x-template.list-item-label label="purchase.project_id">
                    </x-template.list-item-label>
                </div>
                <div class="col-8 col-md-10">
                    {{ $purchase->project_id }}
                </div>
            </div>
        </x-template.list-item>
        <x-template.list-item>
            <div class="row">
                <div class="col-4 col-md-2">
                    <x-template.list-item-label label="purchase.business_type">
                    </x-template.list-item-label>
                </div>
                <div class="col-8 col-md-10">
                    {{ $purchase->business_type }}
                </div>
            </div>
        </x-template.list-item>
    </x-template.list-group>
</x-collapse>

<x-collapse number="3" title="Pricing and tax setting" show>
    <x-template.list-group>
        <x-template.list-item>
            <div class="row">
                <div class="col-4 col-md-2">
                    <x-template.list-item-label label="purchase.vat_type">
                    </x-template.list-item-label>
                </div>
                <div class="col-8 col-md-10">
                    {{ $purchase->vat_type }}
                </div>
            </div>
        </x-template.list-item>
        <x-template.list-item>
            <div class="row">
                <div class="col-4 col-md-2">
                    <x-template.list-item-label label="purchase.currency_code">
                    </x-template.list-item-label>
                </div>
                <div class="col-8 col-md-10">
                    {{ $purchase->currency_code }}
                </div>
            </div>
        </x-template.list-item>
    </x-template.list-group>
</x-collapse>

<x-collapse number="4" title="Item" show>
    <x-item-view-table :data="$items"></x-item-view-table>
</x-collapse>

<x-collapse number="5" title="Summary" show>
    <x-item-summary></x-item-summary>
</x-collapse>

<x-collapse number="6" title="Remark for seller" show>
    <x-textarea label="purchase.remark" name="remark" :value="$purchase->remark"></x-textarea>
</x-collapse>

<x-collapse number="7" title="Attach file to document" show>
</x-collapse>

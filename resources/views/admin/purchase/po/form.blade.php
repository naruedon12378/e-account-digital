<x-form name="frmPurchase" :action="$purchase->id ? route('purchase_orders.update', $purchase->id) : route('purchase_orders.store')" enctype>

    @if ($purchase->id)
        @method('PUT')
        <input type="hidden" name="id" value="{{ $purchase->id }}">
    @endif

    <div class="border-bottom border-success pl-3 pt-3">
        <div class="d-flex justify-content-between flex-wrap align-items-center">
            <div>
                <h5>
                    @if ($purchase->id)
                        Edit
                    @else
                        Create
                    @endif Purchase Order
                </h5>
                <h6 class="text-success mr-5">Approval</h6>
            </div>
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-form-group label="purchase.reference" name="reference" value="{{ $purchase->reference }}">
                    </x-form-group>
                </div>
                <div class="col-12 col-md-6">
                    <x-form-group label="purchase.doc_number" name="doc_number" required value="{{ $purchase->doc_number }}">
                    </x-form-group>
                </div>
            </div>
            @if ($purchase?->id)
                <div class="d-flex align-items-center">
                    @include('admin.purchase.common.po-print')
                    <x-action-group color="secondary" label='<i class="fa-solid fa-bars mr-2"></i> Option'>
                        <a class="dropdown-item" href="javascript:;">
                            <i class="fa-regular fa-copy mr-2"></i>
                            Copy
                        </a>
                        <a class="dropdown-item" href="javascript:;">
                            <i class="fa-solid fa-ban mr-2"></i>
                            Void
                        </a>
                    </x-action-group>
                </div>
            @endif
        </div>
    </div>

    @include('admin.purchase.common.form-body')
    
    <div class="text-center mt-5">
        <x-button-cancel url="{{ route('purchase_orders.index') }}">
            {{ __('file.Cancel') }}
        </x-button-cancel>
        <x-button-group label="Save Draft" color="success">
            <a class="dropdown-item" href="javascript:;">
                Save Draft and create new
            </a>
        </x-button-group>
        <x-button-group label="Approve Purchase Order" color="info">
            <a class="dropdown-item" href="javascript:;">
                Approve and print
            </a>
            <a class="dropdown-item" href="javascript:;">
                Approve and create new
            </a>
            <a class="dropdown-item" href="javascript:;">
                Send for Approval
            </a>
        </x-button-group>
    </div>
</x-form>

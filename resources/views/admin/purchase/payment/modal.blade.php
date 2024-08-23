<div class="modal fade" id="paidModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">
                    Payment #EXP-20240500001
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fa-regular fa-circle-xmark"></i>
                </button>
            </div>
            <div class="modal-body p-0">
                @include('admin.purchase.payment.payment-form')
            </div>
            <div class="modal-footer d-block text-center">
                <x-button-close></x-button-close>
                <x-button id="btnSubmitModal" property='data-dismiss="modal"'>Payment</x-button>
            </div>
        </div>
    </div>
</div>

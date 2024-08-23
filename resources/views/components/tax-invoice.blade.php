<div class="form-group">
    <label for="">Received Tax Invoice</label>
    <div class="divAdd">
        <a href="javascript:;" class="btn btn-link" data-toggle="modal" data-target="#taxInvoiceModal">
            Add tax invoice
        </a>
    </div>
    <div class="divShow"></div>
</div>

<x-modal name="taxInvoiceModal" title="Register Received Tax Invoice">
    <div class="row">
        <div class="col-12 col-md-6">
            <x-datepicker label="Tax Invoice Date" name="tax_invoice_date" :value="$date" required>
            </x-datepicker>
        </div>
        <div class="col-12 col-md-6">
            <x-form-group label="Received Tax Invoice No." name="tax_invoice_number" :value="$number" required>
            </x-form-group>
        </div>
    </div>
</x-modal>

@push('js')
    <script>
        $(document).on('click', '#taxInvoiceModal #btnSubmitModal', function(e) {
            e.preventDefault();
            let date = $('#tax_invoice_date').val();
            let number = $('#tax_invoice_number').val();
            let btnDel =
            `<i class="fa-regular fa-circle-xmark mx-2 js-close" style="font-size: 17px; cursor: pointer;"></i>`;
            $('.divShow').append(number + ', ' + date + btnDel);
            $('.divAdd').hide();
            $('#taxInvoiceModal').modal('hide');
        });
        $(document).on('click', '.js-close', function(){
            $('.divShow').html('');
            $('.divAdd').show();
        });
    </script>
@endpush

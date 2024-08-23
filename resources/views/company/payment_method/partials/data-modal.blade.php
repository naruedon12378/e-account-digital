<form id="form">
    <div class="modal fade" id="modal" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('home.add') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-9">
                            <label class="form-label">{{ __('payment.financial_type') }}</label>
                            <div>
                                @for ($i = 1; $i <= 3; $i++)
                                    <input type="radio" class="chk-group" name="financial_type" id="financial_type"
                                        value='{{ $i }}' {{ $i == 1 ? 'checked' : '' }}>
                                    <span class="mx-1">{{ __('payment.financial_type' . $i) }}</span>
                                @endfor
                            </div>
                        </div>
                        <div class="col-3">
                            <label for="bank_code">{{ __('payment.bank_code') }}</label>
                            <input type="text" class="form-control" name="bank_code" id="bank_code">
                        </div>
                    </div>
                    <div class="section-form row">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        id="close-modal">{{ __('home.cancel') }}</button>
                    <button type="reset" class="btn btn-danger btnReset">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }}" onclick="storeData()">{{ __('home.save') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>

@push('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $("#modal"),
                width: '100%',
            });
        });
    </script>
@endpush

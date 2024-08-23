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
                    <div class="row">
                        <input type="hidden" name="id" id="id">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('doc_setting.group_no') }}</label>
                                        <input class="form-control " name="classification_code" id="classification_code"
                                            required />
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('doc_setting.name') }}</label>
                                        <input class="form-control " name="name" id="name" required />
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <label>{{ __('doc_setting.publish_type') }}</label>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input type="checkbox" name="publish_income" id="publish_income"
                                            class="form-check-input">
                                        <label class="form-check-label">{{ __('doc_setting.income') }}</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-check">
                                        <input type="checkbox" name="publish_expense" id="publish_expense"
                                            class="form-check-input">
                                        <label class="form-check-label">{{ __('doc_setting.expense') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label">{{ __('doc_setting.description') }}</label>
                            <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                        </div>
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

        });
    </script>
@endpush

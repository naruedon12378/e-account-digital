<form id="form2">
    <div class="modal fade" id="modal-child" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title title-name group-name" id="staticBackdropLabel"></h5>
                    <input type="hidden" name="group_code" id="group_code">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="form-label group-description text-black-50"></p>
                    <div class="row">
                        <input type="hidden" name="group_id" id="group_id">
                        <input type="hidden" name="child_id" id="child_id">
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('doc_setting.group_no') }}</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <input type="hidden" name="main_code" id="main_code">
                                        <input type="hidden" name="group_id" id="group_id">
                                        <input type="hidden" name="child_id" id="child_id">
                                        <div class="input-group-text main_code_show" style="height:31px !important">
                                        </div>
                                    </div>
                                    <input class="form-control " name="classification_branch_code"
                                        id="classification_branch_code" required />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">{{ __('doc_setting.name') }}</label>
                                <input class="form-control " name="classification_branch_name"
                                    id="classification_branch_name" required />
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('doc_setting.description') }}</label>
                                <input class="form-control " name="classification_branch_description"
                                    id="classification_branch_description" />
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn mt-4 w-100 {{ env('BTN_THEME') }} btn-save-child"
                                onclick="storeChild()">{{ __('home.add') }}</a>
                        </div>

                        <div class="col-12 text-center">
                            <h5 class="form-label">{{ __('doc_setting.group_child') }} <small class="group-name">
                                </small>
                            </h5>
                        </div>
                        <hr class="w-100 cus-hr my-0">

                        <div class="col-sm-8 offset-2">
                            <table id="show-group-branch" class="table table-hover dataTable no-footer nowrap"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>{{ __('doc_setting.group_no') }}</th>
                                        <th>{{ __('doc_setting.name') }}</th>
                                        <th>{{ __('doc_setting.description') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="child-tbody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            id="close-modal">{{ __('home.close') }}</button>
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

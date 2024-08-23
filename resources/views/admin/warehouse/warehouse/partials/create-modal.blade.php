<div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span class="label" id="label"></span>
                        <span id="modal-label-loading" class="spinner-border spinner-border-sm text-primary"
                            role="status" aria-hidden="true"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <fieldset id="form_field_submit">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    @include('vendor.adminlte.components.form.form-select', [
                                        'name' => 'branch_id',
                                        'label' => 'warehouse.branch',
                                        'isRequired' => true,
                                        'property' => '',
                                        'data' => $branches->pluck('name', 'id'),
                                        'value' => null,
                                        'class' => null,
                                    ])
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            @include('vendor.adminlte.components.form.form-group', [
                                                'name' => 'code',
                                                'label' => 'warehouse.code',
                                                'type' => 'text',
                                                'isRequired' => false,
                                                'property' => '',
                                                'value' => null,
                                                'autocomplete' => 'off',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            @include('vendor.adminlte.components.form.form-group', [
                                                'name' => 'name_th',
                                                'label' => 'warehouse.name_th',
                                                'type' => 'text',
                                                'isRequired' => true,
                                                'property' => '',
                                                'value' => null,
                                                'autocomplete' => 'off',
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="mb-3">
                                    @include('vendor.adminlte.components.form.form-group', [
                                        'name' => 'name_en',
                                        'label' => 'warehouse.name_en',
                                        'type' => 'text',
                                        'isRequired' => false,
                                        'property' => '',
                                        'value' => null,
                                        'autocomplete' => 'off',
                                    ])
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('home.publish') }}</label>
                                    <div class="pl-2 d-inline-block">
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" name="is_active" id="isactive_true" value="true" checked="true" />
                                            <label for="isactive_true">{{ __('home.active') }}</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" name="is_active" id="isactive_false" value="false" />
                                            <label for="isactive_false">{{ __('home.not_active') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <input type="hidden" id="id" name="id">
                <div class="modal-footer">
                    <button type="reset" class="btn btn-outline-danger">{{ __('home.reset') }}</button>
                    <button type="button" class="btn btn-outline-secondary px-5"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button class="btn {{ env('BTN_THEME') }}" onclick="storeorUpdateData()">
                        <span id="btn_submit_loading" class="spinner-border spinner-border-sm" role="status"
                    aria-hidden="true"></span>
                        {{ __('home.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@push('js')
    <script>
        $(document).ready(function() {});
    </script>
@endpush

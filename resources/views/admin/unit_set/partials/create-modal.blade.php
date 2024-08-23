<div class="modal fade" id="addProductTypeModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span class="label"></span>
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
                            <!-- <div class="col-12 col-md-6">
                                <div class="icheck-primary icheck-inline">
                                    <input type="radio" name="type" id="product" value="product" checked />
                                    <label for="product">{{ __('product.product') }}</label>
                                </div>
                                <div class="icheck-primary icheck-inline">
                                    <input type="radio" name="type" id="service" value="service" />
                                    <label for="service">{{ __('product.service') }}</label>
                                </div>
                            </div> -->

                            <div class="col-12 col-md-6">
                                @include('vendor.adminlte.components.form.form-group', [
                                    'name' => 'code',
                                    'label' => 'product_type.code',
                                    'type' => 'text',
                                    'isRequired' => false,
                                    'property' => '',
                                    'value' => null,
                                    'autocomplete' => 'off',
                                ])
                            </div>
                            <div class="col-12">
                                @include('vendor.adminlte.components.form.form-group', [
                                    'name' => 'name_th',
                                    'label' => 'product_type.name_th',
                                    'type' => 'text',
                                    'isRequired' => true,
                                    'property' => '',
                                    'value' => null,
                                    'autocomplete' => 'off',
                                ])
                            </div>
                            <div class="col-12">
                                @include('vendor.adminlte.components.form.form-group', [
                                    'name' => 'name_en',
                                    'label' => 'product_type.name_en',
                                    'type' => 'text',
                                    'isRequired' => false,
                                    'property' => '',
                                    'value' => null,
                                    'autocomplete' => 'off',
                                ])
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label"
                                        for="description">{{ __('product_type.description') }}</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="2"></textarea>
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
                    <button type="button" id="btnSubmit" class="btn btn-outline-primary px-5">
                        <span id="btn_submit_loading" class="spinner-border spinner-border-sm" role="status"
                            aria-hidden="true"></span>
                        {{ __('home.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

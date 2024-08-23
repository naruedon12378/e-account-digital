<div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('product_category.image') }}</label><br />
                                        <img src="https://placehold.co/300x300" id="showimg" width="150"
                                            height="150" style="max-width: 100%; object-fit: cover;"> <br />
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image"
                                                name="image" onchange="return fileValidation(this)" accept="image/*">
                                            <label
                                                class="custom-file-label">{{ __('product_category.choose_file') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">

                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <!-- <label class="form-label">{{ __('product_category.product_type') }}</label>
                                            <select class="select2 form-control" name="product_type_id" id="product_type_id"
                                                style="width: 100%;">
                                                @foreach ($product_types as $product_type)
<option value="{{ $product_type->id }}">{{ $product_type->name_th }}</option>
@endforeach
                                            </select> -->
                                            @include('vendor.adminlte.components.form.form-select', [
                                                'name' => 'product_type_id',
                                                'label' => 'product_category.product_type',
                                                'isRequired' => true,
                                                'property' => '',
                                                'data' => $product_types->pluck('name_th', 'id'),
                                                'value' => null,
                                                'class' => null,
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            @include('vendor.adminlte.components.form.form-group', [
                                                'name' => 'name_th',
                                                'label' => 'product_category.name_th',
                                                'type' => 'text',
                                                'isRequired' => true,
                                                'property' => '',
                                                'value' => null,
                                                'autocomplete' => 'off',
                                            ])
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('product_category.name_en') }}</label>
                                            <input class="form-control " name="name_en" id="name_en" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label"
                                                for="description">{{ __('product_category.description') }}</label>
                                            <textarea class="form-control" name="description" id="description" cols="30" rows="2"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('product.cost_calculation') }}</label>
                                            <div class="pl-2 d-inline-block">
                                                <div class="icheck-primary icheck-inline">
                                                    <input type="radio" name="cost_calculation_type" id="cost_average"
                                                        value="average" checked />
                                                    <label for="cost_average">{{ __('product.cost_average') }}</label>
                                                </div>
                                                <div class="icheck-primary icheck-inline">
                                                    <input type="radio" name="cost_calculation_type" id="cost_fifo"
                                                        value="fifo" />
                                                    <label for="cost_fifo">{{ __('product.cost_fifo') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('home.publish') }}</label>
                                            <div class="pl-2 d-inline-block">
                                                <div class="icheck-primary icheck-inline">
                                                    <input type="radio" name="is_active" id="isactive_true"
                                                        value="true" checked />
                                                    <label for="isactive_true">{{ __('home.active') }}</label>
                                                </div>
                                                <div class="icheck-primary icheck-inline">
                                                    <input type="radio" name="is_active" id="isactive_false"
                                                        value="false" />
                                                    <label for="isactive_false">{{ __('home.not_active') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </fieldset>
                <input type="hidden" id="id" name="id">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger btnReset">{{ __('home.reset') }}</button>
                    <button type="button" class="btn {{ env('BTN_THEME') }}" onclick="storeData()">
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

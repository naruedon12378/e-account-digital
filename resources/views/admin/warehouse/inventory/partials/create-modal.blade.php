<form id="form">
    <div class="modal fade" id="modal-create" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <fieldset id="form_field_submit">
                    <div class="modal-body">
                        <div class="row">
                            <!-- <div class="col-sm-12">
                                <div class="mb-3">
                                    <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                                        {{ __('inventory.inventory_information') }}
                                    </blockquote>
                                </div>
                            </div> -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-select label="inventory.warehouse" name="warehouse_id" class="select2" :data="$warehouses->pluck('name_th', 'id')" required></x-form-select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-select label="inventory.product" name="product_id" class="select2" :data="$products->pluck('name_th', 'id')" required></x-form-select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-group type="number" label="inventory.limit_min_amount" name="limit_min_amount"  placeholder="inventory.insert_amount" min="0" autocomplete="off"></x-form-group>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-group type="number" label="inventory.limit_max_amount" name="limit_max_amount"  placeholder="inventory.insert_amount" min="0" autocomplete="off"></x-form-group>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('inventory.is_negative_amount') }}</label>
                                    <div class="">
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" name="is_negative_amount" id="negative_true" value="true"  />
                                            <label for="negative_true">{{ __('home.active') }}</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" name="is_negative_amount" id="negative_false" value="false" checked/>
                                            <label for="negative_false">{{ __('home.not_active') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('inventory.limit_amount_notification') }}</label>
                                    <div class="">
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" name="limit_amount_notification" id="noti_true" value="true" checked />
                                            <label for="noti_true">{{ __('home.active') }}</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" name="limit_amount_notification" id="noti_false" value="false" />
                                            <label for="noti_false">{{ __('home.not_active') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('home.publish') }}</label>
                                    <div class="">
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" name="status" id="ishold_true" value="onhold"
                                                checked />
                                            <label for="ishold_true">{{ __('inventory.onhold') }}</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" name="status" id="isactive_true" value="active" />
                                            <label for="isactive_true">{{ __('home.active') }}</label>
                                        </div>
                                        <div class="icheck-primary icheck-inline">
                                            <input type="radio" name="status" id="isactive_false" value="inactive" />
                                            <label for="isactive_false">{{ __('home.not_active') }}</label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('inventory.location') }}</label>
                                    <input type="text" class="form-control " name="location" id="location" />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">{{ __('inventory.description') }}</label>
                                    <textarea class="form-control" name="description" id="description"  rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <input type="hidden" id="id" name="id">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.close') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('home.reset') }}</button>
                    <button type="button" class="btn {{ env('BTN_THEME') }}" onclick="storeOrUpdateData()">
                        <span id="btn_submit_loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <i class="fas fa-save mr-2" id="btn_save"></i> {{ __('home.save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        $(document).ready(function() {});
    </script>
@endpush

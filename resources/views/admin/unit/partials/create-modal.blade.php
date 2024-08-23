<x-modal name="addUnitModal" title="{{ __('home.add') }}">
    <x-form name="form" :action="route('units.store')">
        <fieldset id="form_field_submit">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="icheck-primary icheck-inline">
                        <input type="radio" name="type" id="product" value="product" checked />
                        <label for="product">{{ __('product.product') }}</label>
                    </div>
                    <div class="icheck-primary icheck-inline">
                        <input type="radio" name="type" id="service" value="service" />
                        <label for="service">{{ __('product.service') }}</label>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <x-form-group label="unit.code" name="code" required>
                    </x-form-group>
                </div>
                <div class="col-12">
                    <x-form-group label="unit.unit_name_en" name="name_en" required>
                    </x-form-group>
                </div>
                <div class="col-12">
                    <x-form-group label="unit.unit_name_th" name="name_th">
                    </x-form-group>
                </div>
                <div class="col-12">
                    <x-textarea label="unit.description" name="description"></x-textarea>
                </div>
            </div>
        </fieldset>
        <input type="hidden" id="id" name="id">
    </x-form>
</x-modal>

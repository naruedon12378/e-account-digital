<div class="row">
    <div class="col-12 col-md-6 col-lg-8 col-xl-8">
        @include('components.radio', [
            'name' => 'item_class',
            'data' => [
                [
                    'label' => 'product.basic',
                    'value' => 'basic',
                    'checked' => ($class == 'basic' || $class == null)? 'checked':''
                ],
                [
                    'label' => 'product.advance',
                    'value' => 'advance',
                    'checked' => ($class == 'advance')? 'checked':''
                ],
            ],
        ])
    </div>
    <div class="col-12 col-md-6 col-lg-4 col-xl-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">{{ $label }} <span class="text-danger">*</span></span>
            </div>
            <input type="text" class="form-control" name="{{ $name }}" value="{{ $value }}">
        </div>
        <span class="text-danger invalid {{ $name }}"></span>
    </div>
</div>

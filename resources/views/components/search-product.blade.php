<div class="row @if($attributes->has('class')){{ $class }}@endif">
    <div class="col-12 col-md-6">
        <label>{{ trans('file.Select Product') }}</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa fa-barcode"></i>
                </span>
            </div>
            <input type="search" class="form-control" id="inputSearch" 
                placeholder="Please type product code and select..."
                aria-label="Username" aria-describedby="basic-addon1">
        </div>
    </div>
</div>

<table id="logs" class="table table-hover">
    <thead>
        <tr>
            <th>{{ __('product.purchase_date') }}</th>
            <th>{{ __('product.unit_balance') }}</th>
            <th>{{ __('product.unit_price_balance') }}</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if (count($productStocks) > 0)
            @foreach ($productStocks as $stock)
                <tr>
                    <td>
                        <input type="date" class="form-control" name="purchase_date[]" value="{{ $stock->purchase_date }}">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="purchase_qty[]" value="{{ $stock->qty }}">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="price[]" value="{{ $stock->price }}">
                    </td>
                    <td>
                        <button class="btn btn-danger js-delete">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </td>
                    <input type="hidden" name="stock_id[]" value="{{ $stock->id }}">
                </tr>
            @endforeach
        @else
            <tr>
                <td>
                    <input type="date" class="form-control" name="purchase_date[]">
                </td>
                <td>
                    <input type="text" class="form-control" name="purchase_qty[]">
                </td>
                <td>
                    <input type="text" class="form-control" name="price[]">
                </td>
                <td>
                    <button class="btn btn-danger js-delete">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
                <input type="hidden" name="stock_id[]">
            </tr>
        @endif
    </tbody>
</table>

{{-- <style>
    #itemTable td {
        padding: 0 0.4rem 0 0.4rem;
    }
    #itemTable td.pZero {
        padding: 0;
    }
</style> --}}
<div class="table-responsive border-top">
    <table id="itemTable" class="table table-bordered">
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="35%">Product/Service</th>
                <th width="5%">Account</th>
                <th class="text-right" width="5%">Quantity</th>
                <th class="text-right" width="10%">Price/Q</th>
                <th class="text-right" width="5%">Disc./Q</th>
                <th class="text-right" width="10%">VAT</th>
                <th class="text-right" width="15%">Pre-VAT Amount</th>
                <th class="text-right" width="10%">WHT</th>
            </tr>
        </thead>
        <tbody>
            @if($attributes->has('data')) 
                @foreach ($data as $key => $value)
                    <tr>
                        <td>{{ $value['line_item_no'] }}</td>
                        <td>
                            <a href="">{{ $value['code'] }}</a>
                            <small>{{ $value['name'].' '.$value['description'] }}</small>
                        </td>
                        <td>{{ $value['account_code'] }}</td>
                        <td class="text-right">{{ $value['qty'] }}</td>
                        <td class="text-right">{{ $value['price'] }}</td>
                        <td class="text-right">{{ $value['discount'] }}</td>
                        <td class="text-right">
                            {{ $value['vat_amt'] }}
                            <small class="text-secondary">{{ $value['vat_rate'] }}%</small>
                        </td>
                        <td class="text-right">{{ $value['pre_vat_amt'] }}</td>
                        <td class="text-right">
                            {{ $value['wht_amt'] }}
                            <small class="text-secondary">{{ $value['wht_rate'] }}%</small>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
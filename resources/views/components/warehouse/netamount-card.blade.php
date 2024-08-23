{{-- <div class="row">
    <div class="col-sm-12">
        <div class="card shadow-custom bg-custom">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-7">{{ __('inventory_stock.total_net_amount') }}</div>
                    <div class="col-sm-5 text-right">
                        <input type="text" readonly
                            class="inventory_stock_adjustment_amount calSection w-50 text-white text-right"
                            name="inventory_stock_adjustment_amount" value="0.00">
                        {{ __('payroll_salary.baht') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 --}}



<div class="row">
    <div class="col-sm-12">
        <div class="card shadow-custom bg-custom">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-7">{{ __($btnlabel) }}</div>
                    <div class="col-sm-5 text-right">
                        <input type="text" readonly
                            class="  {{ $classname }} calSection w-50 text-white text-right"
                            name="{{ $btnname }}" value="0.00">
                            @if ($isneedcurrency)
                                {{ __($currency) }}
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

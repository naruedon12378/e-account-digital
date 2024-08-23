<style>
    /* Chrome, Safari, Edge, Opera */
    #payment table input::-webkit-outer-spin-button,
    #payment table input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    #payment table input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<div id="payment" class="card rounded-0 border bg-light" style="box-shadow: none !important;">
    <div class="card-body">
        <div class="d-flex justify-content-between flex-wrap align-items-center">
            <div>
                @include('components.radio', [
                    'name' => 'item_class',
                    'data' => [
                        [
                            'label' => 'product.basic',
                            'value' => 'basic',
                            'checked' => 'checked',
                        ],
                        [
                            'label' => 'product.advance',
                            'value' => 'advance',
                            'checked' => '',
                        ],
                    ],
                ])
            </div>
            <div>
                <a href="javascript:;">
                    No payment yet (Payable)
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-between flex-wrap align-items-center">
            <h6>Payment Record No. 1</h6>
            <x-datepicker label="payment_date" name="payment_date" :value="date('Y-m-d')" required>
            </x-datepicker>
        </div>
        <hr>
        <div id="methodacc">
            <div class="icheck-primary d-inline-block" data-toggle="collapse" href="#methodcoll">
                <input type="checkbox" id="payment_method" checked>
                <label for="payment_method">
                    Payment Method
                </label>
            </div>
            <div id="methodcoll" class="collapse show" data-parent="#methodacc">
                <table id="paymentTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="38%">Payment Method</th>
                            <th width="20%" class="text-right">Payment Amount</th>
                            <th width="38%">Remark</th>
                            <th width="2%">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-0 text-center">1</td>
                            <td class="p-0">
                                <select name="payment_method" class="form-control border-0">
                                    @foreach (paymentMethods() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control border-0 text-right" name="paid_amt">
                            </td>
                            <td class="p-0">
                                <input type="text" class="form-control border-0" name="remark">
                            </td>
                            <td class="p-0 text-center"><i class="fa-regular fa-circle-xmark"></i></td>
                        </tr>
                        <tr>
                            <td class="p-0 text-center">2</td>
                            <td class="p-0">
                                <select name="payment_method" class="form-control border-0">
                                    @foreach (paymentMethods() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control border-0 text-right" name="paid_amt">
                            </td>
                            <td class="p-0">
                                <input type="text" class="form-control border-0" name="remark">
                            </td>
                            <td class="p-0 text-center"><i class="fa-regular fa-circle-xmark"></i></td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-link">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Payment Method
                </button>
            </div>
        </div>
        <hr>
        <div id="adjacc">
            <div class="icheck-primary d-inline-block" data-toggle="collapse" href="#adjcoll">
                <input type="checkbox" id="adjustment">
                <label for="adjustment">
                    Fee and Adjustment
                </label>
            </div>
            <div id="adjcoll" class="collapse" data-parent="#adjacc">
                <table id="adjTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="26%">Adjusted by</th>
                            <th width="25%">Record to Account</th>
                            <th width="15%" class="text-right">Adjusted Amount</th>
                            <th width="30%">Remark</th>
                            <th width="2%">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-0 text-center">1</td>
                            <td class="p-0">
                                <select name="adjusted_by" class="form-control border-0">
                                    @foreach (getAccountCodes([5]) as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <select name="account_code" class="form-control border-0">
                                    @foreach (getAccountCodes([5]) as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control border-0 text-right" name="adjusted_amt">
                            </td>
                            <td class="p-0">
                                <input type="text" class="form-control border-0" name="remark">
                            </td>
                            <td class="p-0 text-center"><i class="fa-regular fa-circle-xmark"></i></td>
                        </tr>
                        <tr>
                            <td class="p-0 text-center">2</td>
                            <td class="p-0">
                                <select name="adjusted_by" class="form-control border-0">
                                    @foreach (getAccountCodes([5]) as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <select name="account_code" class="form-control border-0">
                                    @foreach (getAccountCodes([5]) as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control border-0 text-right" name="adjusted_amt">
                            </td>
                            <td class="p-0">
                                <input type="text" class="form-control border-0" name="remark">
                            </td>
                            <td class="p-0 text-center"><i class="fa-regular fa-circle-xmark"></i></td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-link">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Fee and Adjustment
                </button>
            </div>
        </div>
        <hr>
        <div id="settleacc">
            <div class="icheck-primary d-inline-block" data-toggle="collapse" href="#settlecoll">
                <input type="checkbox" id="settlement">
                <label for="settlement">
                    Settle payment
                </label>
            </div>
            <div id="settlecoll" class="collapse" data-parent="#settleacc">
                <table id="settleTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="26%">Document Type</th>
                            <th width="25%">Document No.</th>
                            <th width="15%" class="text-right">Payment Amount</th>
                            <th width="30%">Remark</th>
                            <th width="2%">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-0 text-center">1</td>
                            <td class="p-0">
                                <select name="adjusted_by" class="form-control border-0">
                                    @foreach (getAccountCodes([5]) as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <select name="account_code" class="form-control border-0">
                                    @foreach (getAccountCodes([5]) as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control border-0 text-right" name="adjusted_amt">
                            </td>
                            <td class="p-0">
                                <input type="text" class="form-control border-0" name="remark">
                            </td>
                            <td class="p-0 text-center"><i class="fa-regular fa-circle-xmark"></i></td>
                        </tr>
                        <tr>
                            <td class="p-0 text-center">2</td>
                            <td class="p-0">
                                <select name="adjusted_by" class="form-control border-0">
                                    @foreach (getAccountCodes([5]) as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <select name="account_code" class="form-control border-0">
                                    @foreach (getAccountCodes([5]) as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control border-0 text-right" name="adjusted_amt">
                            </td>
                            <td class="p-0">
                                <input type="text" class="form-control border-0" name="remark">
                            </td>
                            <td class="p-0 text-center"><i class="fa-regular fa-circle-xmark"></i></td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-link">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Settle payment
                </button>
            </div>
        </div>
        <hr>
        <div id="whtacc">
            <div class="icheck-primary d-inline-block" data-toggle="collapse" href="#whtcoll">
                <input type="checkbox" id="wht">
                <label for="wht">
                    Withholding Tax
                </label>
            </div>
            <div id="whtcoll" class="collapse" data-parent="#whtacc">
                <table id="settleTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="2%">#</th>
                            <th width="26%">Withholding Rate</th>
                            <th width="25%">P.N.D Type</th>
                            <th width="15%" class="text-right">Withheld Amount</th>
                            <th width="30%">Tax Condations</th>
                            <th width="2%">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="p-0 text-center">1</td>
                            <td class="p-0">
                                <select name="wht_rate" class="form-control border-0">
                                    @foreach (getWhtRate() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <select name="pnd_type" class="form-control border-0">
                                    @foreach (getWhtRate() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control text-right border-0" name="wht_amt">
                            </td>
                            <td class="p-0">
                                <select name="tax_condition" class="form-control border-0">
                                    @foreach (getWhtRate() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                
                            </td>
                            <td class="p-0 text-center"><i class="fa-regular fa-circle-xmark"></i></td>
                        </tr>
                        <tr>
                            <td class="p-0 text-center">2</td>
                            <td class="p-0">
                                <select name="wht_rate" class="form-control border-0">
                                    @foreach (getWhtRate() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <select name="pnd_type" class="form-control border-0">
                                    @foreach (getWhtRate() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0">
                                <input type="number" class="form-control text-right border-0" name="wht_amt">
                            </td>
                            <td class="p-0">
                                <select name="tax_condition" class="form-control border-0">
                                    @foreach (getWhtRate() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="p-0 text-center"><i class="fa-regular fa-circle-xmark"></i></td>
                        </tr>
                        
                    </tbody>
                </table>
                <button class="btn btn-link">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Withholding Tax
                </button>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-12 col-md-8">
                <x-template.list-group>
                    <x-template.list-item class="bg-light">
                        <div class="row text-right">
                            <div class="col-8">
                                <x-template.list-item-label label="Money Payment" class="end"></x-template.list-item-label>
                            </div>
                            <div class="col-4">
                                <span id="totalStdAmt">
                                    {{ number_format(0.0, 2) }} THB
                                </span>
                            </div>
                        </div>
                    </x-template.list-item>
                    <x-template.list-item class="bg-light">
                        <div class="row text-right">
                            <div class="col-8">
                                <x-template.list-item-label label="Withholding Tax" class="end"></x-template.list-item-label>
                            </div>
                            <div class="col-4">
                                <span id="totalVatAmt">
                                    {{ number_format(0.0, 2) }} THB
                                </span>
                            </div>
                        </div>
                    </x-template.list-item>
                </x-template.list-group>
            </div>
            <div class="col-12 col-md-4">
                <x-template.list-group>
                    <li class="list-group-item border-0 px-3 py-4 bg-info rounded text-right">
                        Total Payment <span id="totalPayment" class="mx-2 text-lg" style="font-size: 18px;">0.00</span> THB
                    </li>
                    <li class="list-group-item border-0 bg-light text-right mt-0 mt-md-3 py-1">
                        Remaining amount : <span id="totalRemaining" class="mx-2">0.00</span> THB
                    </li>
                </x-template.list-group>
            </div>
        </div>
        
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-8">
        <x-template.list-group>
            <x-template.list-item>
                <div class="row text-right">
                    <div class="col-8">
                        <x-template.list-item-label label="Quotation Discount"
                            class="end"></x-template.list-item-label>
                    </div>
                    <div class="col-4">
                        <span class="">
                            {{ number_format(0.0, 2) }} THB
                        </span>
                    </div>
                </div>
            </x-template.list-item>
            <x-template.list-item>
                <div class="row text-right">
                    <div class="col-8">
                        <x-template.list-item-label label="VAT Exempted Amount"
                            class="end"></x-template.list-item-label>
                    </div>
                    <div class="col-4">
                        <span id="totalExmAmt">
                            {{ number_format(0.0, 2) }} THB
                        </span>
                    </div>
                </div>
            </x-template.list-item>
            <x-template.list-item>
                <div class="row text-right">
                    <div class="col-8">
                        <x-template.list-item-label label="VAT0% Amount" class="end"></x-template.list-item-label>
                    </div>
                    <div class="col-4">
                        <span id="totalZerAmt">
                            {{ number_format(0.0, 2) }} THB
                        </span>
                    </div>
                </div>
            </x-template.list-item>
            <x-template.list-item>
                <div class="row text-right">
                    <div class="col-8">
                        <x-template.list-item-label label="VAT7% Amount" class="end"></x-template.list-item-label>
                    </div>
                    <div class="col-4">
                        <span id="totalStdAmt">
                            {{ number_format(0.0, 2) }} THB
                        </span>
                    </div>
                </div>
            </x-template.list-item>
            <x-template.list-item>
                <div class="row text-right">
                    <div class="col-8">
                        <x-template.list-item-label label="VAT Amount" class="end"></x-template.list-item-label>
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
                Net Total <span id="grandTotal" class="mx-2 text-lg" style="font-size: 18px;">0.00</span> THB
            </li>
            <li class="list-group-item border-0 text-right mt-0 mt-md-3 py-1 d-none">
                Withholding Tax Amount <span id="totalWhtAmt" class="mx-2"></span> THB
            </li>
            <li class="list-group-item border-0 text-right py-1 d-none">
                Net Amount to Pay <span id="totalPayAmt" class="mx-2"></span> THB
            </li>
        </x-template.list-group>
    </div>
</div>

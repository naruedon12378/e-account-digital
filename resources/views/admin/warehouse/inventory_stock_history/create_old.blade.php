    @extends('adminlte::page')
    <style>
        .calSection {
            font-weight: bold;
            font-size: 1.2em;
            border: none;
            outline: none;
            background: transparent;
            pointer-events: none;
        }

        .dataTables_scrollBody {
            max-height: 700px !important;
            overflow-y: auto;
        }
    </style>
    @php($pagename = 'Inventory Stock')
    <x-template.pagetitle :page="$pagename" />
    @section('content')
        <x-template.breadcrumb :page="$pagename" />
        <form name="frmInventorystock" action="{{ route('inventorystock.store') }}" method="post" enctype="multipart/form-data"
            id="formData">
            @csrf
            <x-warehouse.card-body>

                <x-warehouse.card-header :pagename="$pagename" number="1" :modalimport="'#modal-import'" :modaldelete="'#modal-delete'"
                    :namelabel="'inventory_stock.import_inventory'" />
                <x-warehouse.card-body>
                    <x-warehouse.card-body-title :bodylabel="'inventory_stock.inventory_information'" :btnid="'additem'" :btnName="'inventory_stock.add_new'">
                    </x-warehouse.card-body-title>
                    <div class="row">
                        <div class="col-sm-12 mb-3 table-responsive" style="width: 100%; overflow-x: auto;">
                            <table id="table" class="table table-hover dataTable no-footer nowrap"
                                style="width: max-content;">
                                <x-warehouse.table-head :mycolumns="$head_columns" />
                                <tbody>
                                    <tr class="emp_rows">
                                        <td>
                                            <select name="inventory[]" class="form-control select2"
                                                style="width: 160px; !important">
                                                <option value="-1" data-inventory="0">{{ __('home.please_select') }}
                                                </option>
                                                @foreach ($inventories as $inventory)
                                                    <option value="{{ $inventory->id }}"
                                                        data-inventory="{{ $inventory->id }}">
                                                        {{ $inventory->id }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="order[]" class="form-control select2" style="width: 160px">
                                                <option value="-1" data-order="0">{{ __('home.please_select') }}
                                                </option>
                                                @foreach ($orders as $order)
                                                    <option value="{{ $order->id }}" data-order="{{ $order->id }}">
                                                        {{ $order->doc_number }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="transaction[]" class="form-control select2" style="width: 160px">
                                                <option value="-1" data-transaction="0">{{ __('home.please_select') }}
                                                </option>
                                                <option value="adjustment" data-transaction="0">Adjustment</option>
                                                <option value="quotation" data-transaction="0">Quotation</option>
                                                <option value="beginning_balance" data-transaction="0">Beginning Balance
                                                </option>
                                                <option value="issue_requisition" data-transaction="0">Issue Requisition
                                                </option>
                                                <option value="reture_issue_stock" data-transaction="0">Reture Issue Stock
                                                </option>
                                                <option value="receipt_planning" data-transaction="0">Receipt Planning
                                                </option>
                                                <option value="receive_finish_stock" data-transaction="0">Receive Finish
                                                    Stock</option>
                                                <option value="transfer_requistion" data-transaction="0">Transfer Requistion
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input name="lot_number[]" style="width: 100px" id="lot_number" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput calCut">
                                        </td>
                                        <td>
                                            <input name="add_amount[]" style="width: 100px" id="add_amount" type="number"
                                                step="0.01" value="0.00" max="100"
                                                class="form-control text-right numberInput">
                                        </td>
                                        <td>
                                            <input name="used_amount[]" style="width: 100px" id="used_amount" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput sumAdd">
                                        </td>
                                        <td>
                                            <input name="remaing_amount[]" style="width: 100px" id="remaing_amount"
                                                type="number" step="0.01" value="0.00"
                                                class="form-control text-right numberInput sumCut">
                                        </td>
                                        <td>
                                            <input name="coust_price[]" style="width: 100px" id="coust_price" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput calTotal">
                                        </td>
                                        <td><a class="btn btn-danger removeitem" id="removeitem"><i
                                                    class="fas fa-trash-alt"></i></a></td>
                                    </tr>
                                </tbody>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <hr class=" border-success p-3 " />
                        </div>
                        <div class="col-sm-12 mb-3">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                {{ __('inventory_stock.total') }} {{ __('inventory_stock.inventory_information') }}
                            </blockquote>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <x-warehouse.item-summary :labelname="'inventory_stock.total_lot_number'" :classname="'total_lot_number_text'" :inputname="'total_lot_number_text'"
                                    :isreadonly="false" :inputvalue="'0'" :currency="'payroll_salary.baht'" :isneedcurrency="false" />
                                <x-warehouse.item-summary :labelname="'inventory_stock.total_add_amount'" :classname="'total_add_amount_text'" :inputname="'total_add_amount_text'"
                                    :isreadonly="false" :inputvalue="'0'" :currency="'payroll_salary.baht'" :isneedcurrency="true" />
                                <x-warehouse.item-summary :labelname="'inventory_stock.total_used_amount'" :classname="'total_used_amount_text'" :inputname="'total_used_amount_text'"
                                    :isreadonly="false" :inputvalue="'0'" :currency="'payroll_salary.baht'" :isneedcurrency="true" />
                                <x-warehouse.item-summary :labelname="'inventory_stock.total_remaining_amount'" :classname="'total_remaining_amount_text'" :inputname="'total_remaining_amount_text'"
                                    :isreadonly="false" :inputvalue="'0'" :currency="'payroll_salary.baht'" :isneedcurrency="true" />
                                <x-warehouse.item-summary :labelname="'inventory_stock.total_coust_price'" :classname="'total_coust_price_text'" :inputname="'total_coust_price_text'"
                                    :isreadonly="false" :inputvalue="'0'" :currency="'payroll_salary.baht'" :isneedcurrency="true" />
                            </div>
                        </div>
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4">
                            <x-warehouse.netamount-card :btnlabel="'inventory_stock.total_net_amount'" :classname="'inventory_stock_adjustment_amount'" :btnname="'inventory_stock_adjustment_amount'"
                                :isneedcurrency="true" :currency="'payroll_salary.baht'" />
                        </div>
                    </div>
                    <hr class="border-success p-3 " />
                    <x-collapse number="6" title="Remark for Inventory Stock " toggle="show">
                        <x-warehouse.textarea label="Remark" name="remark" :value="$inentorystocks->remark"></x-warehouse.textarea>
                    </x-collapse>
                    </x-warehouse.card-body->
                    <div class="card-footer">
                        <div class="float-right">
                            <a class='btn btn-secondary' onclick='history.back();'><i
                                    class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                            <a class='btn btn-warning }}' data-action="0"><i
                                    class="fas fa-file-signature mr-2"></i>{{ __('home.save') }}แบบร่าง</a>
                            <a class='btn {{ env('BTN_THEME') }}' data-action="1" id="btnSubmit"><i
                                    class="fas fa-check"></i>{{ __('home.save') }}</a>
                        </div>
                    </div>
                    </x-warehouse.card-header>
        </form>
    @endsection
    @push('js')
        <script src="{{ asset('js/warehouse/chargeitem.js') }}"></script>
        <script>
            var table;

            function submitData() {
                Swal.fire({
                    title: '{{ __('home.alert_confirm_text') }}',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: '{{ __('home.close') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (table.data().length > 0) {
                            let action = $(element).data('action')
                            $('#action').val(action)
                            $('#form').submit();
                        } else {
                            alert('{{ __('payroll_salary.alert_count_tr') }}');
                        }
                    }
                })
            }

            function calRow() {
                var closestRow = $(this).closest('tr');
                var add_amount = parseFloat(closestRow.find('input[name="add_amount[]"]').val());
                var lot_number = parseFloat(closestRow.find('input[name="lot_number[]"]').val());
                var used_amount = parseFloat(closestRow.find('input[name="used_amount[]"]').val());
                var remaing_amount = parseFloat(closestRow.find('input[name="remaing_amount[]"]').val());
                var coust_price = parseFloat(closestRow.find('input[name="coust_price[]"]').val());
                var total_add_amount = add_amount;
                var total_user_amount = used_amount * lot_number;
                var total_remaing_amount = total_add_amount - total_user_amount;
                var total_coust_price = add_amount * lot_number;
                closestRow.find('input[name="used_amount[]"]').val(total_user_amount);
                closestRow.find('input[name="remaing_amount[]"]').val(total_remaing_amount);
                closestRow.find('input[name="coust_price[]"]').val(total_coust_price);
            }

            function calTotal() {
                var total_lot_number_all = $('input[name="lot_number[]"]');
                var total_add_amount_all = $('input[name="add_amount[]"]');
                var total_used_amount_all = $('input[name="used_amount[]"]');
                var total_remaing_amount_all = $('input[name="remaing_amount[]"]');
                var total_coust_price_all = $('input[name="coust_price[]"]');
                console.log(total_lot_number_all);
                var total_lot_number = 0;
                var total_add_amount = 0;
                var total_used_amount = 0;
                var total_remaing_amount = 0;
                var total_coust_price = 0;
                var total_social_security = 0;
                var total_withholding_tax = 0;
                var total_revenue = 0;
                var total_deduct = 0;

                total_lot_number_all.each(function() {
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total_lot_number += value;
                    }
                });
                total_add_amount_all.each(function() {
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total_add_amount += value;
                    }
                });

                total_used_amount_all.each(function() {
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total_used_amount += value;
                    }
                });

                total_coust_price_all.each(function() {
                    console.log("I am CUST : " + total_coust_price);
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total_coust_price += value;
                    }
                });
                total_remaing_amount_all.each(function() {
                    console.log("I am TOTlaREMAING : " + total_remaing_amount);
                    var value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total_remaing_amount += value;
                    }
                });
                var total_inventory_stock_adjustment_amount = 0;
                total_inventory_stock_adjustment_amount += total_coust_price;
                $('.total_lot_number_text').val(total_lot_number);
                $('.total_amount_text').val(formatter2Digit.format(total_add_amount))
                $('.total_used_amount_text').val(formatter2Digit.format(total_used_amount))
                $('.total_remaining_amount_text').val(formatter2Digit.format(total_remaing_amount))
                $('.total_coust_price_text').val(total_coust_price)
                $('.inventory_stock_adjustment_amount').val(total_inventory_stock_adjustment_amount)
            }
            $(document).ready(function() {
                table = $('#table').DataTable({
                    rowReorder: false,
                    processing: true,
                    scrollY: "100px",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    fixedHeader: true,
                    fixedColumns: {
                        leftColumns: 2,
                        rightColumns: 1
                    },
                    language: {
                        url: "{{ asset('plugins/DataTables/th.json') }}",
                    },
                    columnDefs: [],
                    "dom": 'rtip',
                });
                $('#additem').on('click', function() {
                    var newRowHtml = `
                                        <tr class="emp_rows">
                                            <td>
                                                <select name="inventory[]" class="form-control select2" style="width: 160px; !important">
                                                    <option value="-1" data-inventory="0">{{ __('home.please_select') }}
                                                    </option>
                                                    @foreach ($inventories as $inventory)
                                                        <option value="{{ $inventory->id }}" data-inventory="{{ $inventory->id }}">
                                                            {{ $inventory->id }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="order[]" class="form-control select2" style="width: 160px">
                                                    <option value="-1" data-order="0">{{ __('home.please_select') }}
                                                    </option>
                                                    @foreach ($orders as $order)
                                                        <option value="{{ $order->id }}" data-order="{{ $order->id }}">
                                                            {{ $order->doc_number }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="transaction[]" class="form-control select2" style="width: 160px">
                                                    <option value="-1" data-transaction="0">{{ __('home.please_select') }}</option>
                                                    <option value="adjustment" data-transaction="0">Adjustment</option>
                                                    <option value="quotation" data-transaction="0">Quotation</option>
                                                    <option value="beginning_balance" data-transaction="0">Beginning Balance</option>
                                                    <option value="issue_requisition" data-transaction="0">Issue Requisition</option>
                                                    <option value="reture_issue_stock" data-transaction="0">Reture Issue Stock</option>
                                                    <option value="receipt_planning" data-transaction="0">Receipt Planning</option>
                                                    <option value="receive_finish_stock" data-transaction="0">Receive Finish Stock</option>
                                                    <option value="transfer_requistion" data-transaction="0">Transfer Requistion</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input name="lot_number[]" style="width: 100px" id="lot_number" type="number" step="0.01"
                                                    value="0.00" class="form-control text-right numberInput calCut">
                                            </td>
                                            <td>
                                                <input name="add_amount[]" style="width: 100px" id="add_amount" type="number" step="0.01"
                                                    value="0.00" max="100"
                                                    class="form-control text-right numberInput calCut">
                                            </td>
                                            <td>
                                                <input name="used_amount[]" style="width: 100px" id="used_amount" type="number" step="0.01"
                                                    value="0.00" class="form-control text-right numberInput sumAdd">
                                            </td>
                                            <td>
                                                <input name="remaing_amount[]" style="width: 100px" id="remaing_amount" type="number" step="0.01"
                                                    value="0.00" class="form-control text-right numberInput sumCut">
                                            </td>
                                            <td>
                                                <input name="coust_price[]" style="width: 100px" id="coust_price" type="number" step="0.01"
                                                    value="0.00" class="form-control text-right numberInput calTotal">
                                            </td>
                                            <td><a class="btn btn-danger removeitem" id="removeitem"><i class="fas fa-trash-alt"></i></a></td>
                                        </tr>
                                        `;
                    var newRow = table.row.add($(newRowHtml)).draw(false).node();
                    $(newRow).find('.select2').select2();
                });
                $('#table tbody').on('click', '.removeitem', function() {
                    table.row($(this).parents('tr')).remove().draw();
                });
                $(document).on('change', 'select[name="inventory[]"]', function() {
                    var selectedSalary = $(this).find('option:selected').data('inventory');
                    var formattedSalary = selectedSalary.toFixed(2);
                    $(this).closest('tr').find('input[name="inventory[]"]').val(formattedSalary);
                    calRow.call(this);
                    calTotal();
                });
                $(document).on('change', 'select[name="order[]"]', function() {
                    var selectedSalary = $(this).find('option:selected').data('order');
                    var formattedSalary = selectedSalary.toFixed(2);
                    $(this).closest('tr').find('input[name="order[]"]').val(formattedSalary);
                    calRow.call(this);
                    calTotal();
                });
                $(document).on('change', 'select[name="transaction[]"]', function() {
                    var selectedSalary = $(this).find('option:selected').data('transaction');
                    var formattedSalary = selectedSalary.toFixed(2);
                    $(this).closest('tr').find('input[name="transaction[]"]').val(formattedSalary);
                    calRow.call(this);
                    calTotal();
                });
                $('table').on('input change mouseenter mouseleave focus', 'tr input', function() {
                    calRow.call(this);
                    calTotal();
                });
                $('.numberInput').on('input change', function() {
                    var value = parseFloat($(this).val());
                    var max = parseFloat($(this).attr('max'));
                    if (!isNaN(value)) {
                        if (!isNaN(max) && value > max) {
                            $(this).val(max.toFixed(2));
                        } else {
                            $(this).val(value.toFixed(2));
                        }
                    }
                });
                $(document).on('change', 'input[name="social_security[]"]', function() {
                    var maxValue = parseFloat('100000');
                    var enteredValue = parseFloat($(this).val());
                    if (enteredValue > maxValue) {
                        $(this).val(maxValue.toFixed(2));
                    }
                });
            });

            // var productList = @json(productList());
            // var items = @json(isset($items) ? $items : []);
            // alert(items);

            $(document).on('click', '#formData #btnSubmit', function() {
                alert(JSON.stringify(state.items));
                var productList = @json(productList());
                var items = @json(isset($items) ? $items : []);
                alert(items);
                let formData = new FormData($('#frmInventorystock')[0]);
                let routeName = "{{ route('inventorystock.store') }}";
                // formData.append('items', JSON.stringify(state.items));
                // formData.append('summary', JSON.stringify(state.summary));
                Swal.fire({
                    title: '{{ __('home.alert_confirm_text') }}',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: '{{ __('home.close') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (table.data().length > 0) {
                            console.log(table.data());
                            console.log("{{ $inentorystocks->id }}");
                        } else {
                            alert('{{ __('payroll_salary.alert_count_tr') }}');
                        }
                    }
                })
            });
        </script>
    @endpush

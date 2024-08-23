@extends('adminlte::page')
@php
    $pagename = 'เพิ่มสต็อกสินค้า';
@endphp
@section('content')
    <div class="pt-3">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('inventorylot.index') }}"
                            class="{{ env('TEXT_THEME') }}">ปรับล็อตสินค้า</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>
        <!-- @if ($errors->any())
    <input type="text" name="msg_error" id="msg_error" value="{{ $errors->first() }}">
    @endif -->
        <form method="POST" id="form">
            @csrf
            @method('POST')

            <div class="card {{ env('CARD_THEME') }} card-outline">

                <fieldset id="form_field_submit">
                    <div class="card-body">

                        <!-- <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <blockquote class="quote-primary mt-0">
                                    <p class="h5">{{ __('inventory.warehouse') }} : {{ @$inventory->warehouse->branch->name }}</p>
                                    <p class="h5">{{ __('inventory.branch') }} : {{ @$inventory->warehouse->name }}</p>
                                </blockquote>
                            </div>
                            <div class="col-12 col-md-6">
                                <blockquote class="quote-primary mt-0">
                                    <p class="h5">{{ __('inventory.product') }} : {{ @$inventory->product->name }}</p>
                                </blockquote>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-select label="inventory_lot.warehouse" name="warehouse_id" id="warehouse_id" class="select2" :data="$warehouse_options" required></x-form-select>
                                    <span class="text-danger invalid warehouse_id"></span>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-group label="inventory_lot.lot_number" name="lot_number" required placeholder="inventory_lot.lot_number" autocomplete="off" require></x-form-group>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label>{{ __('inventory_lot.import_date') }}</label>
                                <input type="text" class="form-control inputmask-date datepicker" id="import_date" name="import_date">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label>{{ __('inventory_lot.expiry_date') }}</label>
                                <input type="text" class="form-control inputmask-date datepicker" id="expiry_date" name="expiry_date">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">{{ __('inventory_lot.description') }}</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="2"
                                        placeholder="{{ __('inventory_lot.description') }}"> {{ $inventory_lot->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                    {{ __('inventory_lot.product_items') }}
                                    <a id="additem"
                                        class="btn btn-outline-success float-right">{{ __('inventory_lot.add_product_item') }}</a>
                                </blockquote>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <table id="table" class="table table-hover dataTable no-footer nowrap"
                                    style="width: 100%;">
                                    <thead class="bg-custom">
                                        <tr>
                                            <th class="text-center" style="width: 50px"></th>
                                            <th class="text-center">{{ __('inventory_lot.product') }}
                                            <th class="text-center" style="width: 200px">{{ __('inventory_lot.amount') }}</th>
                                            <th class="text-center" style="width: 200px">{{ __('inventory_lot.cost_price') }}</th>
                                            <th class="text-center" style="width: 100px">{{ __('inventory_lot.actions') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="card-footer">
                    <div class="float-right">
                        <a class='btn btn-secondary' onclick='history.back();'><i
                                class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                        <button type="button" class="btn {{ env('BTN_THEME') }}" onclick="submitFormData()">
                            <span id="btn_submit_loading" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <i class="fas fa-save mr-2" id="btn_save"></i> {{ __('home.save') }}
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>

<!-- @section('plugins.Thailand', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11']) -->
@push('js')
    <script>
        var table;

        function validationData() {

            $('.invalid').html('');

            let status = true;
            if ($('#lot_number').val() == null || $('#lot_number').val() == "") {
                $('.invalid.lot_number').html('กรุณากรอกหมายเลขล็อต');
                status = false;
            }

            const input_selected_products = document.getElementsByName('selected_products[]');
            for (let i = 0; i < input_selected_products.length; i++) {
                if (!input_selected_products[i].value || input_selected_products[i].value == -1) {
                    $('.invalid.selected_products').eq(i).html('กรุณาเลือกกลุ่มสินค้าย่อย');
                    status = false;
                    console.log('selected_products');
                }
            }

            const input_product_amounts = document.getElementsByName('product_amounts[]');
            for (let i = 0; i < input_product_amounts.length; i++) {
                if (Number(input_product_amounts[i].value) < 1) {
                    $('.invalid.amounts').eq(i).html('กรุณากำหนดจำนวนหน่วยย่อย');
                    status = false;
                    console.log('amounts');
                }
            }

            return status;
        }

        function submitFormData() {

            if (!validationData()) {
                return;
            }

            let url = "{{ route('inventorylot.store') }}";
            let formData = new FormData($('#form')[0]);

            formSubmitLoading(true);

            submitForm(url, formData);
        }

        function addTableRowData(table) {

            const ri = table.data().length;

            reOrder = "<i class='fas fa-bars'></i>";
            product = `<x-form-select name="selected_products[]" class="select2" :data="$product_options" :value="-1"></x-form-select><span class="text-danger invalid selected_products"></span>`;
            amount = `<input name="product_amounts[]" type="number" class="form-control" min="1" value="1">
            <span class="text-danger invalid amounts"></span>
            <span class="text-danger invalid">{{ $errors->first('product_amounts.1') }}</span>
            `;
            cost_price = `<input name="product_cost_prices[]" type="number" class="form-control" min="0" value="0">
            <span class="text-danger invalid product_cost_prices"></span>
            <span class="text-danger invalid">{{ $errors->first('product_cost_prices.1') }}</span>`;
            btnDel = '<a class="btn btn-danger removeitem"><i class="fas fa-trash-alt"></i></a>';
            table.row.add([reOrder, product, amount, cost_price, btnDel]).draw(false);
        }

        $(document).ready(function() {

            $('#btn_submit_loading').hide();

            table = $('#table').DataTable({
                // responsive: true,
                rowReorder: true,
                processing: true,
                scrollY: 450,
                scrollCollapse: true,
                paging: false,
                language: {
                    url: "{{ asset('plugins/DataTables/th.json') }}",
                },
                columnDefs: [{
                        className: 'text-center',
                        targets: [0, 4]
                    },
                    {
                        orderable: false,
                        targets: [0, 1, 2, 3, 4]
                    },
                ],
                "dom": 'rtip',
            });

            $('#additem').on('click', function() {
                addTableRowData(table);
            });

            $('#table tbody').on('click', '.removeitem', function() {
                table.row($(this).parents('tr')).remove().draw();
            })

            addTableRowData(table);

        });
    </script>
@endpush
@endsection

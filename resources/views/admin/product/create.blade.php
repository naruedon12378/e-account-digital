@extends('adminlte::page')
@php($pagename = 'จัดการสินค้า/บริการ')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    <x-form-card>
        <x-form name="frmProduct" :action="$product->id ? route('products.update', $product->id) : route('products.store')" enctype>

            @if ($product->id)
                @method('PUT')
                <input type="hidden" name="id" value="{{ $product->id }}">
            @endif

            <div class="border-bottom border-success p-3">
                @include('components.form-head', [
                    'label' => 'Reference',
                    'name' => 'code',
                    'value' => $product->code,
                    'class' => $product->item_class,
                ])
            </div>

            <div class="border-bottom border-success p-3">
                <a class="card-link d-flex justify-content-between" data-toggle="collapse" href="#collapse">
                    <h6>{{ __('product.type') }}</h6>
                </a>
                <div class="icheck-primary icheck-inline">
                    <input type="radio" name="type" id="product" value="product" checked />
                    <label for="product">{{ __('product.product') }}</label>
                    <x-tooltips
                        title="สินค้าที่ขายให้กับลูกค้า ไม่ใช่อุปกรณ์เครื่องใช้สำนักงาน หรือวัสดุสำนักงาน"></x-tooltips>
                </div>
                <div class="icheck-primary icheck-inline">
                    <input type="radio" name="type" id="service" value="service" />
                    <label for="service">{{ __('product.service') }}</label>
                    <x-tooltips
                        title="บริการที่ให้บริการกับลูกค้า ไม่ใช่ค่าใช้จ่ายในสำนักงาน ค่าบริการ หรือ{{ __('home.save') }}ค่าใช้จ่ายต่างๆ"></x-tooltips>
                </div>
            </div>

            <x-collapse number="1" title="{{ __('product.product_information') }}" show>
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <x-form-group label="product.name_th" name="name_th" required :value="$product->name_th">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <x-form-group label="product.name_en" name="name_en" required :value="$product->name_en">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <x-form-select label="product_category.label" name="product_category_id" class="select2" required
                            :value="$product->product_category_id" :data="getProductCategoryOptions()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <x-form-select label="product.unit" name="unit_id" class="select2" required
                            :value="$product->unit_id"></x-form-select>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <x-form-group label="Serial No." name="serial_no" :value="$product_detail ? $product_detail->serial_no : null">
                                </x-form-group>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <x-form-group label="Part No." name="part_no" :value="$product_detail ? $product_detail->part_no : null">
                                </x-form-group>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 advForm d-none">
                        <div class="icheck-primary icheck-inline mt-0">
                            <input type="checkbox" id="chkboxBarcode" name="chkboxBarcode" />
                            <label for="chkboxBarcode">{{ __('product.barcode') }}</label>
                        </div>
                        <input class="form-control" name="barcode_symbology" id="barcode_symbology" readonly />
                    </div>
                    <div class="col-12 advForm d-none">
                        <x-textarea label="product.product_description" name="product_details"
                            :value="$product->product_details"></x-textarea>
                    </div>
                </div>
            </x-collapse>

            <x-collapse number="2" title="{{ __('product.standard_price') }}">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-group label="product.standard_sale_price_per_unit" name="sale_price" type="number" required
                            :value="$product->sale_price">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6 advForm d-none">
                        <x-form-select label="product.vat_rate" name="sale_tax_id" class="select2" required
                            :value="$product->sale_tax_id" :data="getVatRate()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="product.standard_purchase_price_per_unit" name="purchase_price" type="number"
                            required :value="$product->purchase_price">
                        </x-form-group>
                    </div>

                    <div class="col-12 col-md-6 advForm d-none">
                        <x-form-select label="product.vat_rate" name="purchase_tax_id" class="select2" required
                            :value="$product->purchase_tax_id" :data="getVatRate()"></x-form-select>
                    </div>
                </div>
            </x-collapse>

            <x-collapse number="3" title="{{ __('product.price_level') }}">
                @for ($row_number = 1; $row_number <= 5; $row_number++)
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="mb-1">{{ __('product.price_level') . ' ' . $row_number }} </label>
                            <input type="number" class="form-control" id="product_type.{{ $row_number }}"
                                name="product_prices[]"
                                value="{{ old('product_prices.' . $row_number, isset($product->product_prices[$row_number]) ? $product->product_prices[$row_number]->price : null) }}">
                        </div>
                    </div>
                @endfor
            </x-collapse>

            <x-collapse number="4" title="{{ __('product.product_image') }}"
                message="รูปสินค้าและบริการจะแสดงอยู่ที่หน้าเอกสาร Online View รองรับเฉพาะไฟล์ภาพ และระบบแนะนำให้ภาพมีขนาดกว้างคูณยาวที่เท่ากัน">
                @include('vendor.adminlte.components.form.drop-image', [
                    'name' => 'productImage',
                    'file_name' => 'product_image',
                    'value' => $product_images,
                ])
            </x-collapse>

            <x-collapse number="5" title="{{ __('product.accounting_entry_setting') }}" class="advForm d-none">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-select label="product.sale_account" name="sale_account_id" class="select2" required
                            :value="$product->sale_account_id" :data="getAccountCodes(['4'])"></x-form-select>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-select label="product.purchase_account" name="purchase_account_id" class="select2"
                            required :value="$product->purchase_account_id" :data="getAccountCodes(['5'])"></x-form-select>
                    </div>
                </div>
            </x-collapse>

            <x-collapse number="6" title="{{ __('product.cost_calculation') }}" class="advForm d-none"
                message="วิธีการคำนวณต้นทุน เมื่อใช้งานสินค้าแล้วจะไม่สามารถแก้ไขวิธีการคำนวณได้">
                <div class="row">
                    <div class="col-12 col-md-2 text-md-right">
                        <div class="custom-control custom-switch d-inline-block ml-2">
                            <input type="checkbox" class="custom-control-input" id="is_cost_calculation"
                                name="is_cost_calculation" checked value="0">
                            <label class="custom-control-label" for="is_cost_calculation"></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <x-form-select label="product.cost_account" name="cost_account_id" class="select2" required
                            :value="$product->cost_account_id" :data="getAccountCodes(['5'])"></x-form-select>
                    </div>
                    <div class="col-12 col-md-5">
                        <x-form-select label="product.cost_method" name="cost_calculation" class="select2" required
                            :value="$product->cost_calculation" :data="['', 'FIFO']"></x-form-select>
                    </div>
                </div>
            </x-collapse>

            <x-collapse number="7" title="{{ __('product.product_beginning') }}" class="advForm d-none"
                message="ยอดยกมาสินค้าเมื่อกดสร้างแล้วจะไม่สามารถแก้ไข รายการยกมาจะใช้สำหรับคำนวณต้นทุนสินค้าที่ขายก่อน ในกรณีเป็น FIFO เรียงลำดับตามวันที่ซื้อก่อน">
                <div class="row mt-2">
                    <div class="col-12 col-md-2">
                        <button type="button" class="btn btn-outline-primary" onclick="addLot()">
                            <i class="fas fa-plus"></i>
                            {{ __('product.add_lot_beginning') }}
                        </button>
                    </div>
                    <div class="col-12 col-md-10">
                        @include('admin.product.partials.purchase-log', [
                            'productStocks' => $productStocks,
                        ])
                    </div>
                </div>
            </x-collapse>

            <div class="text-center mt-5">
                <x-button-cancel url="{{ route('products.index') }}">
                    {{ __('file.Back') }}
                </x-button-cancel>
                <x-button>{{ __('file.Submit') }}</x-button>
            </div>
        </x-form>
    </x-form-card>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var unitId = "{{ $product->unit_id }}";
            var type = "{{ $product->type }}";
            var formType = "{{ $product->item_class }}";

            chkFormType(formType);
            changePrdType(type, unitId);

            $('input[name="type"]').on('change', function() {
                type = $(this).val();
                changePrdType(type, unitId);
            });

            $("input[name='item_class']").on('change', function() {
                formType = $(this).val();
                chkFormType(formType);
            });
        });

        function changePrdType(type, unitId) {
            var units = {};
            var prdNameTh = "{{ __('product.product_name_th') }}";
            var prdNameEn = "{{ __('product.product_name_en') }}";
            var srvNameTh = "{{ __('product.service_name_th') }}";
            var srvNameEn = "{{ __('product.service_name_en') }}";

            $('#unit_id').children().remove();
            if (type == "service") {
                units = @json(getUnits('service'));
                $('label[for="name_th"]').html(srvNameTh + `<span class="text-danger"> *</span>`);
                $('label[for="name_en"]').html(srvNameEn + `<span class="text-danger"> *</span>`);
            } else {
                units = @json(getUnits('product'));
                $('label[for="name_th"]').html(prdNameTh + `<span class="text-danger"> *</span>`);
                $('label[for="name_en"]').html(prdNameEn + `<span class="text-danger"> *</span>`);
            }
            var index = 0;
            for (const key in units) {
                var option = "";
                if (index == 0) {
                    option = `<option value="">Select...</option><option value="${key}">${units[key]}</option>`;
                } else {
                    option = `<option value="${key}">${units[key]}</option>`;
                }
                $('#unit_id').append(option);
                index++;
            }
            $('#unit_id option[value="' + unitId + '"]').attr('selected', 'selected');
        }

        function addLot() {
            var newRow = $("<tr>");
            var cols = '';
            cols += `<td><input type="date" class="form-control" name="purchase_date[]" ></td>`;
            cols += `<td><input type="text" class="form-control" name="purchase_qty[]" ></td>`;
            cols += `<td><input type="text" class="form-control" name="price[]" ></td>`;
            cols += `<td><button class="btn btn-danger js-delete">
                        <i class="fa-solid fa-trash-can"></i>
                    </button></td>`;
            cols += `<input type="hidden" name="stock_id[]">`;

            newRow.append(cols);
            $("table#logs tbody").prepend(newRow);
        }

        $(document).on('click', '.js-delete', function() {
            $(this).parents('tr').remove();
        });

        function chkFormType(formType) {
            if (formType == "advance") {
                $('div.advForm').removeClass('d-none');
                $('.select2').select2();
            } else {
                $('div.advForm').addClass('d-none');
            }
        }

        $("input[name='is_cost_calculation']").on('change', function() {
            if (!this.checked) {
                $('#cost_account').prop("disabled", true);
            } else {
                $('#cost_account').prop("disabled", false);
            }
        });

        $("input[name='chkboxBarcode']").on('change', function() {
            if (!this.checked) {
                $('#barcode_symbology').prop('readonly', true);
            } else {
                $('#barcode_symbology').prop('readonly', false);
            }
        });

        $(document).on('click', '#btnSubmit', function() {
            let formData = new FormData($('#frmProduct')[0]);
            let routeName = $('#frmProduct').attr('action');
            $.ajax({
                type: "POST",
                url: routeName,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    window.location.href = data;
                },
                error: function(message) {
                    $('.invalid').html('');
                    for (const key in message.responseJSON.errors) {
                        if (key.includes('.')) {
                            let val = key.replace(key.slice(-2), '');
                            $('.invalid.' + val).html(message.responseJSON, errors[key]);
                        } else {
                            $('.invalid.' + key).html(message.responseJSON.errors[key]);
                        }
                    }
                }
            });

        });
    </script>
@endpush

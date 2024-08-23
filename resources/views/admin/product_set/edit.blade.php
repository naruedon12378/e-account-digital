@extends('adminlte::page')
@php
    if ($action == 'edit') {
        $pagename = 'แก้ไชุดสินค้า';
    } else {
        $pagename = 'เพิ่มชุดสินค้า';
    }
@endphp
@section('content')
    <div class="pt-3">
        @include('vendor.adminlte.partials.common.breadcrumb', ['pagename' => $pagename])
        <!-- <div class="row">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background-color: transparent;">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                        class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('member.index') }}"
                                    class="{{ env('TEXT_THEME') }}">จัดการข้อมูลสมาชิก</a></li>
                            <li class="breadcrumb-item active">{{ $pagename }}</li>
                        </ol>
                    </nav>
                </div> -->
        <!-- @if ($errors->any())
    <input type="text" name="msg_error" id="msg_error" value="{{ $errors->first() }}">
    @endif -->
        <form method="POST" id="form">
            @csrf
            @if ($action == 'edit')
                @method('PUT')
                <input type="hidden" name="id" id="id" value="{{ $product_set->id }}">
            @else
                @method('POST')
            @endif
            <div class="card {{ env('CARD_THEME') }} card-outline">
                <fieldset id="form_field_submit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-group label="product_set.name_th" name="name_th" required :value="$product_set->name_th"
                                        placeholder="product_set.name_th" autocomplete="off">
                                    </x-form-group>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-group label="product_set.name_en" name="name_en" :value="$product_set->name_en"
                                        placeholder="product_set.name_en" autocomplete="off">
                                    </x-form-group>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-group label="product_set.code" name="code" required :value="$product_set->code"
                                        placeholder="product_set.code" autocomplete="off">
                                    </x-form-group>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <x-form-group type="number" min="0" label="product_set.sale_price"
                                        name="sale_price" :value="$product_set->sale_price" placeholder="product_set.sale_price">
                                    </x-form-group>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <div class="icheck-primary">
                                        <input name="show_set_price" type="checkbox" id="show_set_price" value="1"
                                            {{ isset($product_set->show_set_price) && $product_set->show_set_price == true ? 'checked' : '' }} />
                                        <label for="show_set_price">แสดงราคาขายชุดสินค้า</label>
                                    </div>
                                    <div class="icheck-primary">
                                        <input name="show_item_price" type="checkbox" id="show_item_price" value="1"
                                            {{ isset($product_set->show_item_price) && $product_set->show_item_price == true ? 'checked' : '' }} />
                                        <label for="show_item_price">แสดงราคาขายสินค้าส่วนประกอบ</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="description">{{ __('product_set.description') }}</label>
                                    <textarea class="form-control" name="description" id="description" cols="30" rows="2"
                                        placeholder="{{ __('product_set.description') }}"> {{ $product_set->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                    {{ __('product_set.product_child') }}
                                    <a id="additem"
                                        class="btn btn-outline-success float-right">{{ __('product_set.add_product_child') }}</a>
                                </blockquote>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <table id="table" class="table table-hover dataTable no-footer nowrap"
                                    style="width: 100%;">
                                    <thead class="bg-custom">
                                        <tr>
                                            <th class="text-center" style="width: 50px"></th>
                                            <th class="text-center">{{ __('product_set.product_child') }}
                                            </th>
                                            <th class="text-center" style="width: 200px">{{ __('product_set.amount') }}
                                            </th>
                                            <th class="text-center" style="width: 100px">{{ __('product_set.actions') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($action == 'edit' || $action == 'duplicate' || old('selected_products'))

                                            @foreach ($product_set->items as $index => $product_item)
                                                <tr>
                                                    <td>
                                                        <i class="fas fa-bars"></i>
                                                    </td>
                                                    <td>
                                                        <x-form-select name="selected_products[]" class="select2"
                                                            :value="old(
                                                                'selected_products.' . $index,
                                                                $product_item->product_id,
                                                            )" :data="$product_options"></x-form-select>
                                                        <span class="text-danger invalid selected_products"></span>
                                                        <span
                                                            class="text-danger invalid">{{ $errors->first('selected_products.0') }}</span>
                                                    </td>
                                                    <td>
                                                        <input name="product_amounts[]" type="number"
                                                            class="form-control" min="1"
                                                            value="{{ old('product_amounts.' . $index, $product_item->amount) }}">
                                                        <span class="text-danger invalid amounts"></span>
                                                        <span
                                                            class="text-danger invalid">{{ $errors->first('product_amounts.0') }}</span>
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-danger removeitem"><i
                                                                class="fas fa-trash-alt"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
            if ($('#code').val() == null || $('#code').val() == "") {
                $('.invalid.code').html('กรุณากรอกรหัส');
                status = false;
            }

            if ($('#name_th').val() == null || $('#name_th').val() == "") {
                $('.invalid.name_th').html('กรุณากรอกชื่อ(ภาษาไทย)');
                status = false;
            }

            // if ($('#sale_price').val() == null || $('#name_th').val() == "" || $('#sale_price').val() < 0) {
            //     $('.invalid.sale_price').html('กรุณากรอกราคาขาย');
            //     status = false;
            // }

            const input_selected_products = document.getElementsByName('selected_products[]');
            for (let i = 0; i < input_selected_products.length; i++) {
                if (!input_selected_products[i].value || input_selected_products[i].value == -1) {
                    $('.invalid.selected_products').eq(i).html('กรุณาเลือกกลุ่มสินค้าย่อย');
                    status = false;
                }
            }

            const input_product_amounts = document.getElementsByName('product_amounts[]');
            for (let i = 0; i < input_product_amounts.length; i++) {
                if (Number(input_product_amounts[i].value) < 1) {
                    $('.invalid.amounts').eq(i).html('กรุณากำหนดจำนวนหน่วยย่อย');
                    status = false;
                }
            }

            return status;
        }

        function submitFormData() {

            if (!validationData()) {
                return;
            }

            let url = "{{ route('productset.store') }}";
            let formData = new FormData($('#form')[0]);

            formSubmitLoading(true);

            const id = $('#id').val()
            if (id && id > 0) {
                url = "{{ route('productset.update', ['productset' => ':id']) }}";
                url = url.replace(':id', id);
                formData.append('_method', 'patch');
            }

            submitForm(url, formData);
        }

        function addTableRowData(table) {

            const ri = table.data().length;

            reOrder = "<i class='fas fa-bars'></i>"
            product = `<x-form-select name="selected_products[]" class="select2" :data="$product_options" :value="-1"></x-form-select>
        <span class="text-danger invalid selected_products"></span>`;
            amount = `<input name="product_amounts[]" type="number" class="form-control" min="1" value="1">
                        <span class="text-danger invalid amounts"></span>
                        <span class="text-danger invalid">{{ $errors->first('product_amounts.1') }}</span>
                        `;
            btnDel = '<a class="btn btn-danger removeitem"><i class="fas fa-trash-alt"></i></a>'
            table.row.add([reOrder, product, amount, btnDel]).draw(false);
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
                        targets: [0, 3]
                    },
                    {
                        orderable: false,
                        targets: [0, 1, 2, 3]
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

            @if ($action == 'create' || empty($product_set->items))
                if (!$('#id').val()) {
                    addTableRowData(table);
                }
            @endif

        });
    </script>
@endpush
@endsection

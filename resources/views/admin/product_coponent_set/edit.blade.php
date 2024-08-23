@extends('adminlte::page')
@php $pagename = 'จัดการหน่วยสินค้าย่อย'; @endphp
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
                <div class="card-header" style="font-size: 20px;">
                    <div class="float-left">
                        {{ $pagename }}
                        <!-- <a href="#" class="btn btn-outline-success mb-2 ml-3" data-toggle="modal"
                                    data-target="#modal-import"><i class="fas fa-file-import mr-2"></i>
                                    {{ __('product_set.import_salary_pay_run') }}
                                </a> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <x-form-select label="product_set.product_parent" name="product_parent_id" class="select2"
                                    required :value="old('product_parent_id', $product_parent_id)" :data="$product_options"></x-form-select>
                                <span class="text-danger invalid">{{ $errors->first('product_parent_id') }}</span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="mb-3">
                                <div class="icheck-primary">
                                    <input name="show_parent_price" type="checkbox" id="show_parent_price" value="1"
                                        {{ isset($product_set->show_parent_price) && $product_set->show_parent_price == true ? 'checked' : '' }} />
                                    <label for="show_parent_price">แสดงราคาขายที่ตัวสินค้าชุด</label>
                                </div>
                                <div class="icheck-primary">
                                    <input name="show_child_price" type="checkbox" id="show_child_price" value="1"
                                        {{ isset($product_set->show_child_price) && $product_set->show_child_price == true ? 'checked' : '' }} />
                                    <label for="show_child_price">แสดงราคาขายที่ส่วนประกอบ</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="description">{{ __('product_set.description') }}</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="2"></textarea>
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
                            <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                                <thead class="bg-custom">
                                    <tr>
                                        <th class="text-center" style="width: 50px"></th>
                                        <th class="text-center">{{ __('product_set.product_child') }}
                                        </th>
                                        <th class="text-center" style="width: 200px">{{ __('product_set.amount') }}</th>
                                        <th class="text-center" style="width: 100px">{{ __('product_set.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($action == 'edit' || old('selected_products'))

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
                                                    <input name="product_amounts[]" type="number" class="form-control"
                                                        min="1"
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
            if ($('#product_parent_id').val() == null || $('#product_parent_id').val() == "") {
                $('.invalid.product_parent_id').html('กรุณาเลือกกลุ่มสินค้าหลัก');
                status = false;
            }

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

            // $('.fas.fa-save').hide();
            // $('#btn_submit_loading').show();
            // $('#form').submit();
            formSubmitLoading(true);

            let url = "{{ route('productset.store') }}";
            let formData = new FormData($('#form')[0]);

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

            if (!$('#id').val()) {
                console.log('id', $('#id').val());
                addTableRowData(table);
            }

        });
    </script>
@endpush
@endsection

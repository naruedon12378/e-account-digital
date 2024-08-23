@extends('adminlte::page')
@php
    if( $action == 'edit' ){
        $pagename = 'แก้ไชุดสินค้า';
    }else{
        $pagename = 'เพิ่มชุดสินค้า';
    }
@endphp
@section('content')
<div class="pt-3">
    @include('vendor.adminlte.partials.common.breadcrumb', ['pagename' => $pagename])
    <!-- <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('member.index') }}"
                            class="{{ env('TEXT_THEME') }}">จัดการข้อมูลสมาชิก</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div> -->
    <!-- @if($errors->any())
        <input type="text" name="msg_error" id="msg_error" value="{{ $errors->first() }}">
    @endif -->
    <form method="POST" id="form">
        @csrf
        @if( $action=='edit' )
            @method('PUT')
            <input type="hidden" name="id" id="id" value="{{ $sale_promotion->id }}">
        @else
            @method('POST')
        @endif
        <div class="card {{ env('CARD_THEME') }} card-outline">
            <fieldset id="form_field_submit">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <x-form-group label="sale_promotion.code" name="code" required :value="$sale_promotion->code" placeholder="sale_promotion.code" autocomplete="off"></x-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <x-form-group label="sale_promotion.name_th" name="name_th" required :value="$sale_promotion->name_th" placeholder="sale_promotion.name_th" autocomplete="off"></x-form-group>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form-group label="sale_promotion.name_en" name="name_en" :value="$sale_promotion->name_en" placeholder="sale_promotion.name_en" autocomplete="off"></x-form-group>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label>{{ __('sale_promotion.discount_percent') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" for="discount_type_percent">
                                        <input class="mt-0" type="radio" id="discount_type_percent" name="discount_type" value="percent" {{ $sale_promotion->discount_type=='percent'?'checked':''}} >
                                    </div>
                                </div>
                                <input type="number" min="0" max="100" class="form-control" id="discount_percent" name="discount_percent" value="{{ $sale_promotion->discount_percent }}" placeholder="{{ __('sale_promotion.discount_percent') }}">
                            </div>
                            <span class="text-danger invalid discount_percent"></span>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <x-form-group type="number" min="0" label="sale_promotion.discount_limit" name="discount_limit" :value="$sale_promotion->discount_limit" placeholder="sale_promotion.discount_limit"></x-form-group>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label>{{ __('sale_promotion.discount_price') }}</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input class="mt-0" type="radio" name="discount_type" value="price" {{ $sale_promotion->discount_type=='price'?'checked':''}} >
                                    </div>
                                </div>
                                <input type="number" class="form-control" name="discount_price" value="{{ $sale_promotion->discount_price }}" placeholder="{{ __('sale_promotion.discount_price') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label>{{ __('sale_promotion.start_date') }}</label>
                            <input type="text" class="form-control inputmask-date datepicker" id="start_date" name="start_date" value="{{ $sale_promotion->start_date }}" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label>{{ __('sale_promotion.end_date') }}</label>
                            <input type="text" class="form-control inputmask-date datepicker" id="end_date" name="end_date" value="{{ $sale_promotion->end_date }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="description">{{ __('sale_promotion.description') }}</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="2" placeholder="{{ __('sale_promotion.description') }}"> {{ $sale_promotion->description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                {{ __('sale_promotion.product_list') }}
                                <a id="additem" class="btn btn-outline-success float-right">{{ __('sale_promotion.add_product') }}</a>
                            </blockquote>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                                <thead class="bg-custom">
                                    <tr>
                                        <th class="text-center" style="width: 50px"></th>
                                        <th class="text-center">{{ __('sale_promotion.product_list') }}</th>
                                        <th class="text-center" style="width: 200px">{{ __('sale_promotion.condition') }}</th>
                                        <th class="text-center" style="width: 150px">{{ __('sale_promotion.amount') }}</th>
                                        <th class="text-center" style="width: 100px">{{ __('sale_promotion.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if( $action=='edit' || old('selected_products') )

                                        @foreach( $sale_promotion->items as $index => $product_item )
                                        <tr>
                                            <td>
                                                <i class="fas fa-bars"></i>
                                            </td>
                                            <td>
                                                <x-form-select name="selected_products[]" class="select2" :value="old('selected_products.'.$index,$product_item->product_id)" :data="$product_options"></x-form-select>
                                                <span class="text-danger invalid selected_products"></span>
                                                <span class="text-danger invalid">{{$errors->first('selected_products.0')}}</span>
                                            </td>
                                            <td>
                                                <x-form-select name="product_conditions[]" class="select2" :value="old('product_conditions.'.$index,$product_item->condition_key)" :data="$condition_options"></x-form-select>
                                                <span class="text-danger invalid product_conditions"></span>
                                                <span class="text-danger invalid">{{$errors->first('product_conditions.0')}}</span>
                                            </td>
                                            <td>
                                                <input name="product_amounts[]" type="number" class="form-control" min="1" value="{{old('product_amounts.'.$index, $product_item->amount)}}">
                                                <span class="text-danger invalid amounts"></span>
                                                <span class="text-danger invalid">{{$errors->first('product_amounts.0')}}</span>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger removeitem"><i class="fas fa-trash-alt"></i></a>
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
                    <a class='btn btn-secondary' onclick='history.back();'><i class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                    <button type="button" class="btn {{ env('BTN_THEME') }}" onclick="submitFormData()">
                        <span id="btn_submit_loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <i class="fas fa-save mr-2" id="btn_save"></i> บันทึก
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

        // if ($('#discount_percent').val() > 100 ) {
        //     $('.invalid.discount_percent').html('จำนวนไม่เกิน 100%');
        //     status = false;
        // }

        const input_selected_products = document.getElementsByName('selected_products[]');
        for (let i = 0; i < input_selected_products.length; i++) {
            if ( !input_selected_products[i].value || input_selected_products[i].value == -1) {
                $('.invalid.selected_products').eq(i).html('กรุณาเลือกสินค้า');
                status = false;
            }
        }

        const input_product_conditions = document.getElementsByName('product_conditions[]');
        for (let i = 0; i < input_product_conditions.length; i++) {
            if ( !input_product_conditions[i].value || input_product_conditions[i].value == -1) {
                $('.invalid.product_conditions').eq(i).html('กรุณาเลือกเงือนไข');
                status = false;
            }
        }


        const input_product_amounts = document.getElementsByName('product_amounts[]');
        for (let i = 0; i < input_product_amounts.length; i++) {
            if (Number(input_product_amounts[i].value) < 1) {
                $('.invalid.amounts').eq(i).html('กรุณากำหนดจำนวนสินค้า');
                status = false;
            }
        }

        return status;
    }

    function submitFormData() {

        if ( !validationData() ) {
            return;
        }

        let url = "{{ route('salepromo.store') }}";
        let formData = new FormData($('#form')[0]);

        formSubmitLoading( true );

        const id = $('#id').val()
        if( id && id>0 ){
            url = "{{ route('salepromo.update', ['salepromo' => ':id']) }}";
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
        condition = `<x-form-select name="product_conditions[]" class="select2" :data="$condition_options" :value="null"></x-form-select>
                    <span class="text-danger invalid product_conditions"></span>`;
        amount = `<input name="product_amounts[]" type="number" class="form-control" min="1" value="1">
                <span class="text-danger invalid amounts"></span>
                <span class="text-danger invalid">{{$errors->first('product_amounts.1')}}</span>
                `;
        btnDel = '<a class="btn btn-danger removeitem"><i class="fas fa-trash-alt"></i></a>'
        table.row.add([reOrder, product, condition, amount, btnDel]).draw(false);
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
            columnDefs: [
                {
                    className: 'text-center',
                    targets: [0, 4]
                },
                // {
                //     orderable: false,
                //     targets: [0, 1, 2, 3]
                // },
            ],
            "dom": 'rtip',
        });

        $('#additem').on('click', function() {
            addTableRowData(table);
        });

        $('#table tbody').on('click', '.removeitem', function() {
            table.row($(this).parents('tr')).remove().draw();
        })

        @if( $action=='create' || empty($sale_promotion->items) )
            if( !$('#id').val() ){
                addTableRowData(table);
            }
        @endif

    });


</script>
@endpush
@endsection

@extends('adminlte::page')
@php $pagename = 'ปรับแก้ไขล็อตสินค้า'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')

    <x-template.pagetitle :page="$pagename"></x-template.pagetitle>
    <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
        <i class="far fa-pen text-muted mr-2"></i> {{ $pagename }}
    </div>

    <div class="row">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background-color: transparent;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}">
                    <i class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('inventory.index') }}" class="{{ env('TEXT_THEME') }}">
                    <i class="fas fa-house-chimney " aria-hidden="true"></i> {{__('inventory.inventory_list')}}</a>
                </li>
                <li class="breadcrumb-item active">{{ $pagename }}</li>
            </ol>
        </nav>
    </div>
    
    <div class="pt-3">

        <form method="PUT" id="form">

            @method('PUT')
            <input type="hidden" name="id" id="id" value="{{ $inventory_lot->id }}">
            
            <div class="card {{ env('CARD_THEME') }} card-outline">
                <fieldset id="form_field_submit">
                    <div class="card-body">
                        
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <blockquote class="quote-primary mt-0">
                                    <p class="h5">{{ __('inventory.lot_number') }} : {{ $inventory_lot->lot_number }}</p>
                                    <p class="h6">{{ __('inventory_lot.editing_round') }} : {{ $inventory_lot->editing_round }}</p>
                                </blockquote>
                            </div>
                            <div class="col-12 col-md-6">
                                <blockquote class="quote-primary mt-0">
                                    <p class="h5">{{ __('inventory.warehouse') }} : {{ @$inventory_lot->warehouse->name }}</p>
                                    <p class="h6">{{ __('inventory.branch') }} : {{ @$inventory_lot->warehouse->branch->name }}</p>
                                </blockquote>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label>{{ __('inventory.creator') }}</label>
                                <input type="text" readonly class="form-control-plaintext" id="lot_number" value="{{@$user_creator_name}}">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label>{{ __('inventory.editor') }}</label>
                                <input type="text" readonly class="form-control-plaintext" id="lot_number" value="{{ $user_editor_name }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label>{{ __('inventory_lot.import_date') }}</label>
                                <!-- <input type="text" class="form-control inputmask-date datepicker" id="import_date" name="import_date" value="{{ $inventory_lot->import_date }}"> -->
                                <input type="text" readonly class="form-control-plaintext" value="{{ $inventory_lot->import_date }}">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label>{{ __('inventory_lot.expiry_date') }}</label>
                                <!-- <input type="text" class="form-control inputmask-date datepicker" id="expiry_date" name="expiry_date" value="{{ $inventory_lot->expiry_date }}"> -->
                                <input type="text" readonly class="form-control-plaintext" value="{{ $inventory_lot->expiry_date }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="remark">{{ __('inventory_lot.remark') }} <span class="text-danger"> *</span></label>
                                    <textarea class="form-control" name="remark" id="remark" cols="30" rows="2"
                                        placeholder="{{ __('inventory_lot.remark') }}" required></textarea>
                                    <span class="text-danger invalid remark"></span>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                    {{ __('inventory_lot.product_items') }}
                                </blockquote>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <table id="table" class="table table-hover dataTable no-footer nowrap"
                                    style="width: 100%;">
                                    <thead class="bg-custom">
                                        <tr>
                                            <th class="text-center" style="width: 50px">#</th>
                                            <th class="text-center">{{ __('inventory_lot.product') }}
                                            <th class="text-center" style="width: 200px">{{ __('inventory_lot.amount') }}</th>
                                            <th class="text-center" style="width: 200px">{{ __('inventory_lot.add_amount') }}</th>
                                            <th class="text-center" style="width: 200px">{{ __('inventory_lot.minus_amount') }}</th>
                                            <!-- <th class="text-center" style="width: 100px">{{ __('inventory_lot.actions') }} -->
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($inventory_lot->inventory_lot_items as $index => $product_item)
                                            <tr>
                                                <td align="center">{{$index+1}}</td>
                                                <td>
                                                    {{ $product_item->product->name }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($product_item->remaining_amount,2) }}
                                                </td>
                                                <td>
                                                    <input name="product_add_amounts[]" type="number" class="form-control" min="0" >
                                                    <span class="text-danger invalid product_add_amounts">{{ $errors->first( "product_add_amounts.$index" ) }}</span>
                                                </td>
                                                <td>
                                                    <input name="product_minus_amounts[]" type="number" class="form-control" min="0" >
                                                    <span class="text-danger invalid product_minus_amounts">{{ $errors->first("product_minus_amounts.'.$index") }}</span>
                                                </td>
                                                <!-- <td>
                                                    <a class="btn btn-danger removeitem"><i
                                                            class="fas fa-trash-alt"></i></a>
                                                </td> -->
                                            </tr>
                                        @endforeach
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

            let status = true;
            $('.invalid').html('');

            if ($('textarea#remark').val() == null || $('textarea#remark').val() == "" ) {
                $('.invalid.remark').html('กรุณากรอกหมายเหตุ');
                status = false;
            }

            const input_add_amounts = document.getElementsByName('product_add_amounts[]');
            const input_minus_amounts = document.getElementsByName('product_minus_amounts[]');
            for (let i = 0; i < input_add_amounts.length; i++) {
                if( Number(input_add_amounts[i].value)>0 && Number(input_minus_amounts[i].value)>0){
                    $('.invalid.product_add_amounts').eq(i).html('สามารถกำหนดจำนวนได้เพียง 1 ประเภท');
                    $('.invalid.product_minus_amounts').eq(i).html('สามารถกำหนดจำนวนได้เพียง 1 ประเภท');
                    status = false;
                }
            }

            return status;
        }

        function submitFormData() {

            if (!validationData()) {
                return;
            }

            let formData = new FormData($('#form')[0]);
            // formSubmitLoading(true);

            const id = $('#id').val();
            url = "{{ route('inventorylot.update', ['inventorylot' => ':id']) }}";
            url = url.replace(':id', id );
            formData.append('inventory_lot_id', id);
            formData.append('_method', 'patch');

            submitForm(url, formData);
        }

        $(document).ready(function() {

            $('#btn_submit_loading').hide();

            table = $('#table').DataTable({
                // responsive: true,
                // rowReorder: true,
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

            // $('#table tbody').on('click', '.removeitem', function() {
            //     table.row($(this).parents('tr')).remove().draw();
            // })

        });
    </script>
@endpush
@endsection

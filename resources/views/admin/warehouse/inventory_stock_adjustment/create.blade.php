@extends('adminlte::page')
@php $pagename = 'ปรับแก้ไขสต๊อกสินค้า'; @endphp
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

        <form method="POST" id="form">
            
            <div class="card {{ env('CARD_THEME') }} card-outline">
                <fieldset id="form_field_submit">
                    <div class="card-body">
                        
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <blockquote class="quote-primary mt-0">
                                    <p class="h5">{{ __('inventory.lot_number') }} : {{ $inventory_stock->lot_number }}</p>
                                    <p class="h6">{{ __('inventory.transaction') }} : {{ $inventory_stock->transaction_data->name }}</p>
                                    <p class="h6">{{ __('inventory.date') }} : {{ $inventory_stock->date }}</p>
                                </blockquote>
                            </div>
                            <div class="col-12 col-md-6">
                                <blockquote class="quote-primary mt-0">
                                    <p class="h5">{{ __('inventory.warehouse') }} : {{ $warehouse_name }}</p>
                                    <p class="h6">{{ __('inventory.branch') }} : {{ @$branch_name }}</p>
                                </blockquote>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 mb-2">
                                <label>{{ __('inventory.creator') }}</label>
                                <div class="form-control-plaintext">{{$user_creator_name}}</div>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <label>{{ __('inventory.approver') }}</label>
                                <div class="form-control-plaintext">{{ $user_approver_name }}</div>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <label>{{ __('inventory.editor') }}</label>
                                <div class="form-control-plaintext">{{ $user_editor_name }}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <label>{{ __('inventory.product') }}</label>
                                <div class="form-control-plaintext">{{$product_name}}</div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label>{{ __('inventory.cost_price') }}</label>
                                <div class="form-control-plaintext">{{$inventory_stock->cost_price}}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mb-2">
                                <label>{{ __('inventory.used_amount') }}</label>
                                <div class="form-control-plaintext">{{$inventory_stock->used_amount}}</div>
                            </div>
                            <div class="col-sm-3 mb-2">
                                <label>{{ __('inventory.adjust_amount') }}</label>
                                <div class="form-control-plaintext">{{$inventory_stock->adjust_amount}}</div>
                            </div>
                            <div class="col-sm-3 mb-2">
                                <label>{{ __('inventory.remaining_amount') }}</label>
                                <div class="form-control-plaintext">{{$inventory_stock->remaining_amount}}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <label>{{ __('inventory.adjust_amount') }} <span class="text-danger"> *</span></label>
                                <x-tooltips title="ระบุจำนวนที่ต้องการเพิ่มหรือลด โดยการลดจำนวนให้ใส่จำนวนติดลบ(-)" class="text-info"></x-tooltips>
                                
                                <input type="number" class="form-control" id="adjust_amount" name="adjust_amount" value="G" min="-{{$inventory_stock->remaining_amount}}">
                                <span class="text-danger invalid adjust_amount"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="remark">{{ __('inventory.remark') }} <span class="text-danger"> *</span></label>
                                    <textarea class="form-control" name="remark" id="remark" cols="30" rows="2"
                                        placeholder="{{ __('inventory.remark') }}" required></textarea>
                                    <span class="text-danger invalid remark"></span>
                                </div>
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

@push('js')
    <script>
        var table;
        function validationData() {

            let status = true;
            $('.invalid').html('');

            var adjust_amount = $('#adjust_amount').val(); 
            if ( adjust_amount && $.isNumeric(adjust_amount) && adjust_amount!==0 ) {
                if( adjust_amount < {{-$inventory_stock->remaining_amount}} ){
                    $('.invalid.adjust_amount').html('จำนวนต้องไม่น้อยกว่าจำนวนคงเหลือ');
                    status = false;
                }
            }else{
                $('.invalid.adjust_amount').html('กรุณากรอกจำนวน');
                status = false;
            }

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
            url = "{{ route('inventorystockadjustment.store') }}";
            // url = url.replace(':id', id );
            formData.append('stock_id', {{$inventory_stock->id}});
            formData.append('remaining_amount', {{$inventory_stock->remaining_amount}});
            // formData.append('_method', 'post');

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

        });
    </script>
@endpush
@endsection

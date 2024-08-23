@extends('adminlte::page')
@php $pagename = 'อนุมัติแก้ไขสต๊อกสินค้า'; @endphp
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
                                    <p class="h5">{{ __('inventory.product') }} : {{ $product_name }}</p>
                                    <p class="h6">{{ __('inventory.lot_number') }} : {{ $inventory_stock_adjustment->inventory_stock->lot_number }}</p>
                                    <p class="h6">{{ __('inventory.transaction') }} : {{ $inventory_stock_adjustment->inventory_stock->transaction_data->name }}</p>
                                    <p class="h6">{{ __('inventory.date') }} : {{ $inventory_stock_adjustment->inventory_stock->date }}</p>
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
                                <label>{{ __('inventory.date') }}</label>
                                <div class="form-control-plaintext text-bold text-lg  text-right">{{ $inventory_stock_adjustment->date }}</div>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <label>{{ __('inventory.remaining_amount') }}</label>
                                <div class="form-control-plaintext text-bold text-lg text-right">{{ number_format($inventory_stock_adjustment->inventory_stock->remaining_amount, 2)}}</div>
                            </div>
                            <div class="col-sm-4 mb-2">
                                <label>{{ __('inventory.adjust_amount') }}</label>
                                <div class="form-control-plaintext text-bold text-lg text-right">{!!$inventory_stock_adjustment->adjust_amount!!}</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label class="form-label" for="remark">{{ __('inventory.remark') }}</label>
                                    <div class="form-control-plaintext">{{$inventory_stock_adjustment->remark}}</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <label>{{ __('inventory.creator') }}</label>
                                <div class="form-control-plaintext">{{$user_creator_name}}</div>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <label>{{ __('inventory.approver') }}</label>
                                <div class="form-control-plaintext">{{ $user_approver_name }}</div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="card-footer">
                    <div class="float-right">
                        <a class='btn btn-secondary' onclick='history.back();'><i class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                        @if($inventory_stock_adjustment->status == 'pending')
                            <button type="button" class="btn btn-danger" onclick="approveStockData('cancel', {{$inventory_stock_adjustment->id}})">
                                <i class="fas fa-times mr-2" ></i> {{ __('home.not_approved') }}
                            </button>
                            <button type="button" class="btn {{ env('BTN_THEME') }}" onclick="approveStockData('approve', {{$inventory_stock_adjustment->id}})">
                                <span id="btn_submit_loading" class="spinner-border spinner-border-sm" role="status"></span>
                                <i class="fas fa-save mr-2" id="save"></i> {{ __('inventory_lot.approve_stock') }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </form>
    </div>

@push('js')
    <script>

        function approveStockData(type='approve', id){

            let title = '';
            let display_option = {};
            let _method = 'patch';
            if(type=='approve'){
                url = "{{ route('inventorystockadjustment.approve', ['id' => ':id']) }}";
                title = 'ยืนยัน อนุมัติแก้ไขสต้อกสินค้ารายการนี้!?\n<small>เมื่ออนุมัติแล้ว จำนวนสต็อคสินค้าจะถูกเปลี่ยนแปลงอัติโนมัติ</small>';
            }
            else if(type=='cancel'){
                url = "{{ route('inventorystockadjustment.destroy', ['inventorystockadjustment' => ':id']) }}";
                title = 'ไม่อนุมัติการแก้ไขสต็อกสินค้ารายการนี้?';
                display_option = {
                    theme: 'danger',
                };
                _method = 'delete';
            }

            if( url ){
                url = url.replace(':id', id );
                let formData = new FormData();
                apiConfirmRequestData(url, _method, formData, title, display_option).then( function (resp){
                    setTimeout(() => {
                        window.location.href = "{{ route('inventorystockadjustment.index') }}";
                    }, 1500);
                });
            }
        }

        $(document).ready(function() {
            $('#btn_submit_loading').hide();
        });
    </script>
@endpush
@endsection

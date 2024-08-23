@extends('adminlte::page')
@php $pagename = 'อนุมัติรายการเพิ่มสต็อกสินค้า'; @endphp
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

    <div class="card {{ env('CARD_THEME') }} shadow-custom">

        <div class="card-body">
                        
            <div class="row mb-3">
                <div class="col-12 col-md-6">
                    <blockquote class="quote-primary mt-0">
                        <p class="h5">{{ __('inventory.lot_number') }} : {{ $inventory_lot->lot_number }}</p>
                        <p class="h6">{{ __('inventory.creator') }} : {{ $user_creator_name }}</p>
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
                        <label class="form-label" for="remark">{{ __('inventory_lot.remark') }}</label>
                        <p>{{ $inventory_lot->description }}</p>
                    </div>
                </div>
            </div>

            <hr />

            <div class="row">
                <div class="col-sm-12 mb-3">
                    <blockquote class="quote-success text-md" style="margin: 0 !important;">
                        {{ __('inventory_lot.product_import_list') }}
                    </blockquote>
                </div>
                <div class="col-sm-12 mb-3">
                    <table id="table" class="table table-hover no-footer nowrap" style="width: 100%;">
                        <thead class="bg-custom">
                            <tr>
                                <th class="text-center" style="width: 50px">#</th>
                                <th class="text-center">{{ __('inventory_lot.product') }}
                                <th class="text-center" style="width: 200px">{{ __('inventory_lot.cost_price') }}</th>
                                <th class="text-center" style="width: 200px">{{ __('inventory_lot.adjustment_amount') }}</th>
                                <th class="text-center" style="width: 200px">{{ __('inventory_lot.added_amount') }}</th>
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
                                        {{ number_format($product_item->cost_price,2) }}
                                    </td>
                                    <td class="text-right">
                                        @if ( $product_item->adjust_amount > 0)
                                            <span class="text-success">+{{ number_format($product_item->adjust_amount,2) }}</span>
                                        @elseif( $product_item->adjust_amount < 0 )
                                            <span class="text-danger">{{ number_format($product_item->adjust_amount,2) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        {{ number_format($product_item->remaining_amount,2) }}
                                    </td>
                                    <!-- <td>
                                        <input name="product_add_amounts[]" type="number" class="form-control" min="0" >
                                        <span class="text-danger invalid product_add_amounts">{{ $errors->first( "product_add_amounts.$index" ) }}</span>
                                    </td>
                                    <td>
                                        <input name="product_minus_amounts[]" type="number" class="form-control" min="0" >
                                        <span class="text-danger invalid product_minus_amounts">{{ $errors->first("product_minus_amounts.'.$index") }}</span>
                                    </td> -->
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

            <hr>

            <div class="row">
                <div class="col-sm-12 mb-3">
                    <blockquote class="quote-danger text-md" style="margin: 0 !important;">
                        {{ __('inventory_lot.product_adjust_list') }}
                    </blockquote>
                </div>

                @foreach ($inventory_lot->inventory_lot_adjustments as $index => $inventory_lot_adjustment)
                    
                    @if(count($inventory_lot_adjustment->inventory_lot_adjustment_items) > 0)
                        <div class="col-sm-12 mb-3">
                            <h6 class="text-bold">รอบแก้ไขที่ {{$index+1}}</h6>
                            <div class="row">
                                <div class="col-3">
                                    <div>{{ __('inventory_lot.product_amount_edit') }}</div>
                                    <p>{{ number_format( count($inventory_lot_adjustment->inventory_lot_adjustment_items)) }}</p>
                                </div>
                                <div class="col-3">
                                    <div>{{ __('inventory_lot.remark') }}</div>
                                    <p>{{ $inventory_lot_adjustment->remark }}</p>
                                </div>
                                <div class="col-3">
                                    <div>{{ __('inventory_lot.user_editor') }}</div>
                                    <p>{{ $inventory_lot_adjustment->user_editor_name }}</p>
                                </div>
                                <div class="col-3 text-center">
                                    @if ( $inventory_lot_adjustment->status == 'pending')
                                        <button type="button" class="btn btn-danger" onclick="approveAdjustData('cancel', {{$inventory_lot->id}},{{$inventory_lot_adjustment->id}})">
                                            <i class="fas fa-times mr-2" id="adjust_cancel"></i> {{ __('inventory_lot.not_approve_adjustment') }}
                                        </button>
                                        <button type="button" class="btn {{ env('BTN_THEME') }}" onclick="approveAdjustData('approve', {{$inventory_lot->id}},{{$inventory_lot_adjustment->id}})">
                                            <i class="fas fa-check mr-2" id="adjust_approve"></i> {{ __('inventory_lot.approve_adjustment') }}
                                        </button>
                                    @else
                                        @if ( $inventory_lot_adjustment->status == 'approve')
                                            <div class="bs alert alert-success">{{ __('inventory_lot.approve_adjustment') }}</div>
                                        @elseif ( $inventory_lot_adjustment->status == 'cancel')
                                            <div class="bs alert alert-danger">{{ __('inventory_lot.not_approve_adjustment') }}</div>
                                        @endif
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-12 mb-3">
                            <table id="table" class="table table-hover no-footer nowrap" style="width: 100%;">
                                <thead class="">
                                    <tr>
                                        <th class="text-center" style="width: 50px">#</th>
                                        <th class="text-center">{{ __('inventory_lot.product') }}
                                        <th class="text-center" style="width: 150px">{{ __('inventory_lot.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inventory_lot_adjustment->inventory_lot_adjustment_items as $index_table => $inventory_lot_adjustment_item)
                                        <tr>
                                            <td align="center">{{$index_table+1}}</td>
                                            <td>
                                                {{ $inventory_lot_adjustment_item->product->name }}
                                            </td>
                                            <td class="text-right text-bold">
                                                @if ( $inventory_lot_adjustment_item->add_amount > 0 )
                                                    <span class="text-success">+{{ number_format($inventory_lot_adjustment_item->add_amount,2) }}</span>
                                                @elseif( $inventory_lot_adjustment_item->minus_amount > 0 )
                                                    <span class="text-danger">-{{ number_format($inventory_lot_adjustment_item->minus_amount,2) }}</span>
                                                @else
                                                    {{ number_format(0,2) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endforeach
                <hr>
            </div>
        </div>

        <div class="card-footer">
            <div class="float-right">
                <a class='btn btn-secondary' onclick='history.back();'><i class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                @if($inventory_lot->status == 'pending')
                    <button type="button" class="btn btn-danger" onclick="approveStockData('cancel', {{$inventory_lot->id}})">
                        <i class="fas fa-times mr-2" ></i> {{ __('home.not_approved') }}
                    </button>
                    <button type="button" class="btn {{ env('BTN_THEME') }}" onclick="approveStockData('approve', {{$inventory_lot->id}})">
                        <span id="btn_submit_loading" class="spinner-border spinner-border-sm" role="status"></span>
                        <i class="fas fa-save mr-2" id="save"></i> {{ __('inventory_lot.approve_stock') }}
                    </button>
                @endif
            </div>
        </div> 
    </div>
</div>


@push('js')
<script>
    $(document).ready(function() {
        formSubmitLoading(false);
    });

    function approveAdjustData( type='approve', lot_id, adjustment_id ){

        let title = '';
        let display_option = {};
        if(type=='approve'){
            url = "{{ route('inventorylot.approve_adjustment', ['lot_id' => ':id','adj_id' => ':adj_id']) }}";
            title = 'ยืนยัน อนุมัติรายการแก้ไขนี้!?\n<small>เมื่ออนุมัติแล้ว จำนวนสินค้าในล็อตจะถูกเปลี่ยนแปลง</small>';
        }
        else if(type=='cancel'){
            url = "{{ route('inventorylot.cancel_adjustment', ['lot_id' => ':id','adj_id' => ':adj_id']) }}";
            title = 'ไม่อนุมัติรายการแก้ไขนี้?';
            display_option = {
                theme: 'danger',
            };
        }

        if( url ){
            url = url.replace(':id', lot_id );
            url = url.replace(':adj_id', adjustment_id );
            let formData = new FormData();
            apiConfirmRequestData(url, 'patch', formData, title, display_option).then( function (resp){
                setTimeout(() => {
                    location.reload();
                }, 1500);
            });
        }
    }

    function approveStockData(type='approve', lot_id){

        let title = '';
        let display_option = {};
        let _method = 'patch';
        if(type=='approve'){
            url = "{{ route('inventorylot.approve_lot', ['lot_id' => ':id']) }}";
            title = 'ยืนยัน การอนุมัติรายการล็อตสินค้านี้!?\n<small>เมื่ออนุมัติแล้ว จำนวนสินค้าภายในล็อตจะถูกเพิ่มเข้าสต๊อกอัติโนมัติ</small>';
        }
        else if(type=='cancel'){
            url = "{{ route('inventorylot.destroy', ['inventorylot' => ':id']) }}";
            title = 'ไม่อนุมัติรายการล็อตสินค้านี้?';
            display_option = {
                theme: 'danger',
            };
            _method = 'delete';
        }

        if( url ){
            url = url.replace(':id', lot_id );
            let formData = new FormData();
            apiConfirmRequestData(url, _method, formData, title, display_option).then( function (resp){
                setTimeout(() => {
                    window.location.href = "{{ route('inventorylot.index') }}";
                }, 1500);
            });
        }
    }

</script>
@endpush
@endsection

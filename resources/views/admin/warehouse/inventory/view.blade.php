@extends('adminlte::page')
@php $pagename = 'ข้อมูลสินค้าคงคลัง'; @endphp
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
                        <p class="h5">{{ __('inventory.warehouse') }} : {{ @$inventory->warehouse->branch->name }}</p>
                        <p class="h5">{{ __('inventory.branch') }} : {{ @$inventory->warehouse->name }}</p>
                    </blockquote>
                </div>
                <div class="col-12 col-md-6">
                    <blockquote class="quote-primary mt-0">
                        <p class="h5">{{ __('inventory.product') }} : {{ @$inventory->product->name }}</p>
                    </blockquote>
                </div>
            </div>

            <div class="row mb-3">

               <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info"><i class="fas fa-circle-arrow-down"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('inventory.stock_in') }}</span>
                            <span class="info-box-number">{{number_format($total_add_amount,2)}}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger"><i class="fas fa-circle-arrow-up"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('inventory.stock_out') }}</span>
                            <span class="info-box-number">{{number_format($total_remove_amount,2)}}</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix hidden-md-up"></div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-boxes-stacked"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('inventory.remaining_lot') }}</span>
                            <span class="info-box-number">
                                10
                                <small>%</small>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success"><i class="fas fa-box"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">{{ __('inventory.remaining_stock') }}</span>
                            <span class="info-box-number">{{number_format($inventory->amount,2)}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card {{ env('CARD_THEME') }} shadow-custom">
        <div class="card-body">

            <div class="d-flex justify-content-between">
                <div>
                    <blockquote class="quote-primary text-md" style="margin: 0 !important;">
                        {{ __('inventory.stock_history') }}
                    </blockquote>
                </div>
            </div>

            <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                <thead class="bg-custom">
                    <tr>
                        <th class="text-center" style="width: 10%">No.</th>
                        <th class="text-center" style="width: 10%">{{ __('inventory.import_date') }}</th>
                        <th class="text-center" style="width: 10%">{{ __('inventory.transaction') }}</th>
                        <th class="text-center" style="width: 10%">{{ __('inventory.document_code') }}</th>
                        <th class="text-center" style="width: 10%">{{ __('inventory.added_amount') }}</th>
                        <th class="text-center" style="width: 10%">{{ __('inventory.used_amount') }}</th>
                        <th class="text-center" style="width: 10%">{{ __('inventory.adjustment_amount') }}</th>
                        <th class="text-center" style="width: 10%">{{ __('inventory.remaining_amount') }}</th>
                        <th class="text-center" style="width: 10%">{{ __('home.creator') }}</th>
                        <th class="text-center" style="width: 10%">{{ __('home.approver') }}</th>
                        <th class="text-center" style="width: 10%">{{ __('home.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
</div>


@push('js')
<script>
    var table;
    $(document).ready(function() {
        table = $('#table').DataTable({
            pageLength: 50,
            responsive: true,
            processing: true,
            scrollX: true,
            scrollCollapse: true,
            language: {
                url: "{{ asset('plugins/DataTables/th.json') }}",
            },
            serverSide: true,
            searchDelay: 500,
            ajax: {
                url: '',
                data: function(data) {
                    data.warehouse_id = $('#warehouse_select').val();
                }
            },
            data: {
                warehouse_id: 200,
            },
            columnDefs: [
                {
                    className: 'text-center',
                    targets: [0, 1]
                },
                {
                    className: 'text-right',
                    targets: [4,5,6,7]
                },
                {
                    orderable: false,
                    targets: [5, 6]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'date',
                },
                {
                    data: 'transaction_name',
                    defaultContent: "<div class='empty-data'></div>"
                },
                {
                    data: 'document_code',
                    defaultContent: "<div class='empty-data'></div>"
                },
                {
                    data: 'add_amount',
                    defaultContent: "0.00"
                },
                {
                    data: 'used_amount',
                    defaultContent: "0.00"
                },
                {
                    data: 'adjust_amount',
                    defaultContent: "0.00"
                },
                {
                    data: 'remaining_amount',
                    defaultContent: "0.00"
                },
                {
                    data: 'creator_name',
                    defaultContent: "<div class='empty-data'></div>"
                },
                {
                    data: 'approver_name',
                    defaultContent: "<div class='empty-data'></div>"
                },
                {
                    data: 'action',
                },

            ],
            order: [
                [2, 'asc']
            ],
            "dom": 'rtip',
        });
    });
</script>
@endpush
@endsection

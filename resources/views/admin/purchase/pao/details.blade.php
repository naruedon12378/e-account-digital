@extends('adminlte::page')
@php($pagename = 'Purchase Order Asset')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    {!! $purchase->progress_style !!}
    <x-form-card>
        <x-form-tabs :tabs="$tabs">
            <x-tab-content id="home" active>

                <div class="border-bottom border-success pl-3 pt-1">
                    <div class="d-flex justify-content-between flex-wrap align-items-center">
                        <div>
                            <h5>Purchase Order No.# {{ $purchase->doc_number }}</h5>
                            <div class="d-flex justify-content-start">
                                <h6 class="text-success mr-5">Approval</h6>
                                <h6 for="">Reference 012345678</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <x-action-group color="primary" label='<i class="fa-regular fa-paper-plane mr-2"></i> Send'>
                                <a class="dropdown-item" href="javascript:;">
                                    <i class="fa-regular fa-envelope"></i> Email
                                </a>
                            </x-action-group>
                            @include('admin.purchase.common.po-print')
                            @include('admin.purchase.common.po-option')
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Purchase Order</span>
                                    <span class="info-box-number">Approval</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.purchase.common.detail-body')

            </x-tab-content>
            <x-tab-content id="comment">
                <x-comment table="purchase_asset_orders" :id="$purchase->id"></x-comment>
            </x-tab-content>
            <x-tab-content id="history">
                <x-history :doc="$purchase->doc_number" :histories="$histories"></x-history>
            </x-tab-content>
        </x-form-tabs>
    </x-form-card>
@endsection

@push('js')
    @include('admin.purchase.js.common')
@endpush

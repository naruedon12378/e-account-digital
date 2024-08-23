@extends('adminlte::page')
@php($pagename = 'Expense Record')
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
                            <h5>Expense Record No.# {{ $purchase->doc_number }}</h5>
                            <div class="d-flex justify-content-start">
                                <h6 class="text-success mr-5">Approval</h6>
                                <h6 for="">Reference 012345678</h6>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            @include('admin.purchase.common.pi-print')
                            @include('admin.purchase.common.pi-option')
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Expense Record</span>
                                    <span class="info-box-number">Approval</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.purchase.common.detail-body')

            </x-tab-content>

            <x-tab-content id="payment">
                <div class="border-bottom border-success p-3">
                    <div class="d-flex justify-content-between flex-wrap align-items-center">
                        <div>
                            <h5>Expense Record No.# {{ $purchase->doc_number }}</h5>
                            <div class="d-flex justify-content-start">
                                <h6 class="text-success mr-5">Approval</h6>
                                <h6 for="">Reference 012345678</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-bottom border-success">
                    <div class="row">
                        <div class="col-12 col-md-6 border-right border-success py-3">
                            <x-template.list-group>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-8 col-md-6">
                                            <x-template.list-item-label label="Expense Record Full Payment Amount">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            2,140.00 THB
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-8 col-md-6">
                                            <x-template.list-item-label label="Total Net Amount to Payment">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            2,140.00 THB
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-8 col-md-6">
                                            <x-template.list-item-label label="Paid in 1 item">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            2,140.00 THB
                                        </div>
                                    </div>
                                </x-template.list-item>
                            </x-template.list-group>
                        </div>
                        <div class="col-12 col-md-6 py-3">
                            <h5 class="text-info">Expense Record is Fully Paid</h5>
                            <label for="">Fully Paid on : 07/06/2024</label>
                        </div>
                    </div>
                </div>
                <div class="border-bottom border-success">
                    <div class="row">
                        <div class="col-12 col-md-6 border-right border-success py-3">
                            <x-template.list-group>
                                <x-template.list-item>
                                    <h6 class="text-info">Payment Record No.1</h6>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-8 col-md-6">
                                            <x-template.list-item-label label="Payment Date">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            07/06/2024
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-8 col-md-6">
                                            <x-template.list-item-label label="Payment Method">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            <span>Cash - เงินสด</span>
                                            2,140.00 THB
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-8 col-md-6">
                                            <x-template.list-item-label label="Withholding Tax">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            40.00 THB
                                        </div>
                                    </div>
                                </x-template.list-item>
                            </x-template.list-group>
                        </div>
                        <div class="col-12 col-md-6 py-3">
                            <x-template.list-group>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-8 col-md-6">
                                            <x-template.list-item-label label="Journal No.">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            PV-202406001
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row align-items-center">
                                        <div class="col-8 col-md-6">
                                            <x-template.list-item-label label="Total Payment Amount">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-4 col-md-6">
                                            <div class="p-3 bg-info rounded">
                                                <span class="text-lg">2,140.00 THB</span>
                                            </div>
                                        </div>
                                    </div>
                                </x-template.list-item>
                            </x-template.list-group>
                        </div>
                    </div>
                </div>
            </x-tab-content>
            
            <x-tab-content id="comment">
                <x-comment table="purchase_invoices" :id="$purchase->id"></x-comment>
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

@extends('adminlte::page')
@php($pagename = 'Purchase Asset Record')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    {!! $purchase?->progress_style !!}
    <x-form-card>
        @if ($purchase?->id)
            <x-form-tabs :tabs="$tabs">
                <x-tab-content id="home" active>
                    @include('admin.purchase.pai.form')
                </x-tab-content>
                <x-tab-content id="comment">
                    <x-comment table="purchase_asset_invoices" :id="$purchase->id"></x-comment>
                </x-tab-content>
                <x-tab-content id="history">
                    <x-history :doc="$purchase->doc_number" :histories="$histories"></x-history>
                </x-tab-content>
            </x-form-tabs>
        @else
            @include('admin.purchase.pai.form')
        @endif
    </x-form-card>
@endsection

@push('js')
    @include('admin.purchase.js.common')
    @include('admin.purchase.js.submit-form')
@endpush
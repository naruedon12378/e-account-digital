@extends('adminlte::page')
@php($pagename = 'Beginning Balance')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>
@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    @if ($beginningBalance->id)
        @include('admin.warehouse.beginningbalance.create-form')
    @else
        @include('admin.warehouse.beginningbalance.create-form')
    @endif
@endsection

@push('js')
    @include('admin.warehouse.js.warehouseGlobal')
    @include('admin.warehouse.js.warehouseGlobalSubmit')
@endpush

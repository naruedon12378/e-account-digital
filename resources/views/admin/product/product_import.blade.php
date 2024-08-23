@extends('adminlte::page')
@php($pagename = 'จัดการสินค้า/บริการ')
@section('title', setting('title') . ' | ' . $pagename)

@section('content')
    @include('vendor.adminlte.partials.common.breadcrumb', ['pagename' => $pagename])
     @include('components.template.common-buttons', [
        'permissions' => ['*', 'all product', 'create product'],
        'export' => [
            'url' => 'products/export',
            'isActive' => true,
        ],
        'import' => [
            'url' => 'products/import',
            'isActive' => true,
        ],
        'new' => [
            'url' => 'products/create',
            'id' => 'btnNewItem',
            'label' => 'Create Product'
        ],
        'print' => [
            'url' => null,
            'isActive' => false,
        ]
    ])
    <div class="card shadow-custom">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <h1 class="card-title">{{ __('product.product_import') }}</h1>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4">
                    <h1>Coming Soon!</h1>
                </div>
            </div>
        </div>

    </div>

@endsection

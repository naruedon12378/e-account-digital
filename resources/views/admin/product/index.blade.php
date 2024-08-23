@extends('adminlte::page')
@php($pagename = 'จัดการสินค้า/บริการ')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
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
            'label' => 'Create Product',
        ],
        'print' => [
            'url' => null,
            'isActive' => false,
        ],
    ])

    <x-index.card>
        @include('components.index.nav-tabs', $tabs)
        <form id="frmIndex" action="{{ route('products.index') }}">
            <input type="hidden" name="status">
        </form>

        @include('components.index.datatable', [
            'columns' => [
                'product_code',
                'product_category',
                'product_name',
                'unit',
                'stock',
                'sale_price',
                'status',
                'actions',
            ],
            'file' => 'product',
            'id' => 'table',
            'class' => '',
        ])
    </x-index.card>

    @push('js')
        <script>
            $(document).ready(function() {
                const columns = [{
                        data: 'id'
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'name_th'
                    },
                    {
                        data: 'product_category.name_th',
                        defaultContent: "<div class='empty-data'></div>",
                    },
                    {
                        data: 'unit'
                    },
                    {
                        data: 'qty'
                    },
                    {
                        data: 'sale_price'
                    },
                    {
                        data: 'isActive',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        className: 'text-center'
                    },
                ];
                dataTable(columns);

            });

            $(document).on('click', '.nav .nav-link', function() {

            });

        </script>
    @endpush

    @include('admin.product.partials.import-modal')
@endsection

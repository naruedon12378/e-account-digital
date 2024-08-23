@extends('adminlte::page')
@php($pagename = 'Contacts')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    @include('components.template.common-buttons', [
        'permissions' => ['*', 'all contact', 'create contact'],
        'import' => [
            'url' => null,
            'isActive' => true,
        ],
        'export' => [
            'url' => null,
            'isActive' => true,
        ],
        'new' => [
            'url' => 'contacts/create',
            'id' => 'btnNewItem',
            'label' => 'Create Contact',
        ],
        'print' => [
            'url' => null,
            'isActive' => false,
        ],
    ])

    <x-index.card>
        @include('components.index.nav-tabs', $tabs)
        @include('components.index.datatable', [
            'columns' => ['company_code', 'company_name', 'company_type', 'status', 'Action'],
            'file' => 'contact',
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
                        data: 'showLink'
                    },
                    {
                        data: 'party_name'
                    },
                    {
                        data: 'party_type'
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
        </script>
    @endpush
@endsection

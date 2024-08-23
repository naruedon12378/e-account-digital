@extends('adminlte::page')
@php($pagename = 'Quotation')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    @include('components.template.common-buttons', [
        'permissions' => ['*', 'all quotation', 'create quotation'],
        'import' => [
            'url' => null,
            'isActive' => false,
        ],
        'export' => [
            'url' => null,
            'isActive' => false,
        ],
        'new' => [
            'url' => 'revenue/quotations/create',
            'id' => 'btnNewItem',
            'label' => 'Create Quotation',
        ],
        'print' => [
            'url' => 'revenue/quotations/print',
            'isActive' => true,
        ],
    ])

    <x-index.card>
        @include('components.index.nav-tabs', $tabs)
        <div class="mb-3">
            <form id="frmIndex" class="form-inline" action="{{ route('quotations.index') }}">
                <input type="hidden" name="status" value="{{ $status }}">

                <label for="issue_date">Issue Date:</label>
                <x-daterangepicker class="mx-2" name="issue_date" :from="$fromDate" :to="$toDate"></x-daterangepicker>

                <x-button type="submit" class="secondary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </x-button>
            </form>
        </div>

        @include('components.index.datatable', [
            'columns' => ['Doc No.', 'Customer', 'Issue Date', 'Valid Date', 'Net Amount', 'Status'],
            'file' => 'quotation',
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
                        data: 'editLink'
                    },
                    {
                        data: 'customer_id'
                    },
                    {
                        data: 'issue_date'
                    },
                    {
                        data: 'expire_date'
                    },
                    {
                        data: 'grand_total',
                        className: 'text-right'
                    },
                    {
                        data: 'status',
                        className: 'text-center'
                    }
                ];
                dataTable(columns);
            });

            $(document).on('click', '#tabBar', function() {
                let para = $(this).attr('data-id');
                $('#frmIndex input[name="status"]').val(para);
                $('#frmIndex').submit();
            });
        </script>
    @endpush
@endsection

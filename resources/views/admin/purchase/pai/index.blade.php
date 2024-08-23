@extends('adminlte::page')
@php($pagename = 'Purchase Asset')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    @include('components.template.common-buttons', [
        'permissions' => ['*', 'all expense', 'create expense'],
        'import' => [
            'url' => null,
            'isActive' => false,
        ],
        'export' => [
            'url' => null,
            'isActive' => false,
        ],
        'new' => [
            'url' => 'purchase_ledger/purchase_asset_invoices/create',
            'id' => 'btnNewItem',
            'label' => 'Purchase Asset',
        ],
        'print' => [
            'url' => null,
            'isActive' => false,
        ],
    ])

    <x-index.card>
        @include('components.index.nav-tabs', $tabs)
        <div class="mb-3">
            <form id="frmIndex" class="form-inline" action="{{ route('purchase_asset_invoices.index') }}">
                <input type="hidden" name="status" value="{{ $status }}">

                <label for="issue_date">Issue Date:</label>
                <x-daterangepicker class="mx-2" name="issue_date" :from="$fromDate" :to="$toDate"></x-daterangepicker>

                <x-button type="submit" class="secondary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </x-button>
            </form>
        </div>
        
        @include('admin.purchase.common.pi-table')
    </x-index.card>

    @include('admin.purchase.payment.modal')

    @push('js')
        <script>
            $(document).ready(function() {
                var status = "{{ $status }}";
                const columns = [{
                        data: 'id'
                    },
                    {
                        data: 'editLink'
                    },
                    {
                        data: 'seller_id'
                    },
                    {
                        data: 'issue_date'
                    },
                    {
                        data: 'grand_total'
                    },
                    {
                        data : status == 'all'?'status':'action'
                    }
                ];
                dataTable(columns);
            });
        </script>
    @endpush
@endsection

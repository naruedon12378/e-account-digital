@extends ('adminlte::page')
@php $pagename = __('inventory.stock_history'); @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    @include('components.template.common-buttons', [
        'permissions' => ['*', 'all inventory_stock_history', 'create inventory_stock_history'],
        'export' => [
            'url' => 'products/export',
            'isActive' => true,
        ],
        'import' => [
            'url' => 'products/import',
            'isActive' => false,
        ],
        'print' => [
            'url' => null,
            'isActive' => true,
        ],
    ])

    <x-index.card>

        <div class="row mb-2">
            <div class="col-4">
                <form id="from_filter" action="{{ route('inventorystockhistory.index') }}">
                    <select class="form-control" name="whid" id="warehouse_select" placeholder="เลือกคลังสินค้า">
                        <option value="" selected>ทั้งหมด</option>
                        @foreach ($warehouses as $key => $item)
                            <option value="{{ $item['id'] }}" @if ($item['id'] == $warehouse_id) selected @endif>{{ $item['name_th'] }}</option>
                        @endforeach
                    </select>

                    <!-- <button type="button" class="btn btn-outline-secondary ml-3" id="bt_search" onclick="getData()">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button> -->
                </form>
            </div>
        </div>

        @include('components.index.nav-tabs-datatable', $tabs)
        <form id="frmIndex" action="{{ route('inventorystockhistory.index') }}">
            <input type="hidden" name="status">
        </form>

        @include('components.index.datatable', [
            'columns' => [
                'date',
                'warehouse',
                'transaction',
                'document_code',
                'product_code',
                'product',
                'adjustment_amount',
            ],
            'file' => 'inventory',
            'id' => 'table',
            'class' => '',
        ])
    </x-index.card>

    @push('js')
        <script>

            var table;
            $(document).ready(function() {
                const columns = [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'date'
                    },
                    {
                            data: 'warehouse_name',
                    },
                    {
                        data: 'transaction_name',
                    },
                    {
                        data: 'document_code',
                        defaultContent: "<div class='empty-data'></div>",
                    },
                    {
                        data: 'product_code',
                        defaultContent: "<div class='empty-data'></div>",
                    },
                    {
                        data: 'product_name',
                    },
                    {
                        data: 'adjustment_amount',
                        className: 'text-right'
                    },
                    // {
                    //     data: 'action',
                    //     className: 'text-center'
                    // },
                ];

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
                    ajax: {
                        url: '',
                        data: function(data) {
                            data.warehouse_id = $('#warehouse_select').val();
                        }
                    },
                    columns : columns,
                    columnDefs: [{
                            className: 'text-center',
                            targets: [0, 1]
                        },
                        // {
                        //     orderable: false,
                        //     targets: [0, 1, 4]
                        // },
                        // {
                        //     targets: [3],
                        //     createdCell: function(td, cellData, rowData, row, col) {
                        //         $(td).css({
                        //             'font-weight': 'bold',
                        //             'text-align': 'left',
                        //             'text-transform': 'uppercase'
                        //         });
                        //     }
                        // }
                    ],
                });
            });

            //custom search datatable
            $('#warehouse_select').change(function(el) {
                if ('URLSearchParams' in window) {
                    const url = new URL(window.location)
                    if( el.target.value >=1 ){
                        url.searchParams.set('whid', el.target.value)
                    }else{
                        url.searchParams.delete('whid')
                    }
                    history.pushState(null, '', url);
                }

                location.reload();
                // table.ajax.reload();
            })

            $(document).on('click', '.nav .nav-link', function() {

            });

        </script>
    @endpush

    <!-- @include('admin.product.partials.import-modal') -->
@endsection
@endsection

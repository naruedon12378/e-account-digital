@extends ('adminlte::page')
@php $pagename = __('inventory.stock_history'); @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="fas fa-house-user text-muted mr-2"></i> {{ $pagename }}
        </div>

        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>

        <div class="card {{ env('CARD_THEME') }} shadow-custom">
            <div class="card-body">
                <div class="float-left mb-2">
                    <div class="group">
                        <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                            <g>
                                <path
                                    d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                                </path>
                            </g>
                        </svg>
                        <input type="search" id="custom-search-input" class="form-control  input-search"
                            placeholder="ค้นหา">
                    </div>
                </div>

                <div class="text-right">
                    @if (Auth::user()->hasAnyPermission(['*', 'all inventory_stock', 'create inventory_stock']))
                        {{-- <a href="#" class="btn btn-outline-danger mb-2"><i class="fas fa-file-export mr-2"></i>
                            {{ __('inventory_stock.export_report') }}
                        </a> --}}

                        <a href="javascript:void(0)" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2" data-toggle="modal"
                            data-target="#modal-create"><i class="fas fa-plus mr-2"></i>
                            {{ __('inventory_stock.add_inventory') }}</a>
                    @endif
                    @if (Auth::user()->hasAnyPermission(['*', 'all inventory_stock', 'create inventory_stock']))
                    @endif
                </div>
                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" style="width: 10%">{{ __('inventory_stock.number') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('inventory_stock.inventory') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('inventory_stock.order') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('inventory_stock.transaction') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('inventory_stock.add_amount') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('inventory_stock.used_amount') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('inventory_stock.remaining_amount') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('inventory_stock.coust_price') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('inventory_stock.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])

    @push('js')
        <script>
            var table;

            $(document).ready(function() {
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
                    ajax: "",
                    columnDefs: [{
                            className: 'text-center',
                            targets: [0, 1, 4]
                        },
                        {
                            orderable: false,
                            targets: [0, 1, 4]
                        },
                        {
                            targets: [3],
                            createdCell: function(td, cellData, rowData, row, col) {
                                $(td).css({
                                    'font-weight': 'bold',
                                    'text-align': 'left',
                                    'text-transform': 'uppercase'
                                });
                            }
                        }
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'inventory.warehouse.name_en',
                            defaultContent: "<div class='empty-data'>-</div>"
                        },
                        {
                            data: 'order.doc_number',
                            name: 'order.doc_number',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'transaction',
                            name: 'transaction',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'add_amount',
                            name: 'add_amount',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'used_amount',
                            name: 'used_amount',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'remaining_amount',
                            name: 'remaining_amount',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'coust_price',
                            name: 'coust_price',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'action',
                            name: 'action',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                    ],
                    order: [
                        [1, 'asc']
                    ],
                    dom: 'rtip',
                });
            });
            $('#custom-search-input').keyup(function() {
                table.search($(this).val()).draw();
            });
            $('#modal-create').on('hidden.bs.modal', function(event) {
                $("#form")[0].reset();
            })
            $('#modal-edit').on('hidden.bs.modal', function(event) {
                $("#form")[0].reset();
            });

            function storeData(url) {
                if ($('#inventory_id').val() == null || $('#inventory_id').val() == "") {
                    $('.invalid.inventory_id').html('Please select inventory');
                    return false;
                } else {
                    console.log("inventory_id: ", $('#inventory_id').val());
                }
                if ($('#order_id').val() == null || $('#order_id').val() == "") {
                    $('.invalid.order_id').html('Please select order');
                    return false;
                } else {
                    console.log("order_id: ", $('#order_id').val());
                }
                if ($('#transaction').val() == null || $('#transaction').val() == "") {
                    $('.invalid.transaction').html('Please select transaction');
                    return false;
                } else {
                    console.log("transaction: ", $('#transaction').val());
                }
                url = "{{ route('inventorystock.store') }}";
                formdata = new FormData();
                formdata.append('_token', '{{ csrf_token() }}');
                formdata.append('inventory_id', $('#inventory_id').val());
                formdata.append('order_id', $('#order_id').val());
                formdata.append('transaction', $('#transaction').val());
                formdata.append('lot_number', $('#lot_number').val());
                formdata.append('add_amount', $('#add_amount').val());
                formdata.append('used_amount', $('#used_amount').val());
                formdata.append('remaining_amount', $('#remaining_amount').val());
                formdata.append('coust_price', $('#coust_price').val());
                formdata.append('remark', $('#remark').val());
                submitData(url, formdata);
            }

            function requestData(response) {
                $('#eid').val(response.inventorystock.id);
                $('#einventory_id').val(response.inventorystock.inventory_id);
                $('#eorder_id').val(response.inventorystock.order_id);
                $('#etransaction').val(response.inventorystock.transaction);
                $('#elot_number').val(response.inventorystock.lot_number);
                $('#eadd_amount').val(response.inventorystock.add_amount);
                $('#eused_amount').val(response.inventorystock.used_amount);
                $('#eremaining_amount').val(response.inventorystock.remaining_amount);
                $('#ecoust_price').val(response.inventorystock.coust_price);
                $('#eremark').val(response.inventorystock.remark);
                $('#modal-edit').modal('show');
            }

            function updateData() {
                if ($('#einventory_id').val() == null || $('#einventory_id').val() == "") {
                    $('.invalid.inventory_id').html('Please select inventory');
                    return false;
                }

                if ($('#eorder_id').val() == null || $('#eorder_id').val() == "") {
                    $('.invalid.order_id').html('Please select order');
                    return false;
                }

                if ($('#etransaction').val() == null || $('#etransaction').val() == "") {
                    $('.invalid.transaction').html('Please select transaction');
                    return false;
                }

                let url = '{{ route('inventorystock.update', ['inventorystock' => ':id']) }}';
                var id = $('#eid').val();
                url = url.replace(':id', id);
                formdata = new FormData();
                formdata.append('_token', '{{ csrf_token() }}');
                formdata.append('id', $('#eid').val());
                formdata.append('inventory_id', $('#einventory_id').val());
                formdata.append('order_id', $('#eorder_id').val());
                formdata.append('transaction', $('#etransaction').val());
                formdata.append('lot_number', $('#elot_number').val());
                formdata.append('add_amount', $('#eadd_amount').val());
                formdata.append('used_amount', $('#eused_amount').val());
                formdata.append('remaining_amount', $('#eremaining_amount').val());
                formdata.append('coust_price', $('#ecoust_price').val());
                formdata.append('remark', $('#eremark').val());
                submitData(url, formdata);
            }
        </script>
    @endpush
    @include('admin.warehouse.inventorystock.partials.create-modal')
    @include('admin.warehouse.inventorystock.partials.edit-modal')
@endsection

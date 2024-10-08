@extends('adminlte::page')
@php $pagename = 'จัดการสินค้าคงคลัง'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-pen text-muted mr-2"></i> {{ $pagename }}
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
                <div class="row mb-2">
                    <div class="col-4">
                        <form id="from_filter" action="{{ route('inventory.index') }}">
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
                    <div class="col-8 d-flex justify-content-end">
                        <div class="group">
                            <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                                <g>
                                    <path
                                        d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                                    </path>
                                </g>
                            </svg>
                            <input type="search" id="custom-search-input" class="form-control" style="padding-left: 40px;" placeholder="ค้นหา">
                        </div>
                        @if (Auth::user()->hasAnyPermission(['*', 'all inventory', 'create inventory']))
                            <div class="ml-4">
                                <a href="" class="btn  btn-outline-primary" data-toggle="modal"
                                    data-target="#modal-create" id="btn_create"><i class="fas fa-plus mr-2"></i> {{ __('inventory.add_inventory') }}</a>
                            </div>
                        @endif
                    </div>
                </div>

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center">{{ __('inventory.number') }}</th>
                            <th class="text-center">{{ __('inventory.warehouse') }}</th>
                            <th class="text-center">{{ __('inventory.product_name') }}</th>
                            <th class="text-center">{{ __('inventory.remaining_stock') }}</th>
                            <th class="text-center">{{ __('inventory.location') }}</th>
                            <th class="text-center">{{ __('inventory.status') }}</th>
                            <th class="text-center">{{ __('inventory.actions') }}</th>
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
                    searchDelay: 500,
                    ajax: {
                        url: '',
                        data: function(data) {
                            data.warehouse_id = $('#warehouse_select').val();
                        }
                    },
                    data: {
                        warehouse_id: 200,
                    },
                    columnDefs: [
                        {
                            className: 'text-center',
                            targets: [0, 5, 6]
                        },
                        {
                            className: 'text-right',
                            targets: [3]
                        },
                        {
                            orderable: false,
                            targets: [5, 6]
                        },
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'warehouse_name',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'product_name',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'amount',
                            defaultContent: "0.00"
                        },
                        {
                            data: 'location',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'status',
                            defaultContent: "<div class='empty-data'></div>"
                        },
                        {
                            data: 'action',
                            defaultContent: "<div class='empty-data'>-</div>"
                        },

                    ],
                    order: [
                        [2, 'asc']
                    ],
                    "dom": 'rtip',
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

                table.ajax.reload();
            })

            $('#custom-search-input').keyup(function() {
                table.search($(this).val()).draw();
            })

            $('#btn_create').on('click', function() {
                formSubmitLoading( false );
                $("#form")[0].reset();
                $('#modal_title').html("{{ __('inventory.add_inventory') }}");
            });

            $(document).on('click', '.js-edit', function() {

                formSubmitLoading( true );
                $('#modal_title').html("{{ __('inventory.edit_inventory') }}");
                $('#modal-create').modal('show');

                const id = $(this).attr('data-id');
                $.get('inventory/' + id + '/edit', function(sale_promotions) {
                    formSubmitLoading( false );
                    for (const key in sale_promotions) {
                        if (key == "is_negative_amount") {
                            if( sale_promotions[key] ){
                                $('#negative_true').prop('checked', true);
                            }else{
                                $('#negative_false').prop('checked', true);
                            }
                        }
                        else if (key == "limit_amount_notification") {
                            if( sale_promotions[key] ){
                                $('#noti_true').prop('checked', true);
                            }else{
                                $('#noti_false').prop('checked', true);
                            }
                        }
                        else if (key == "status") {
                            if (sale_promotions[key] === 'onhold') {
                                $('#ishold_true').prop('checked', true);
                            } else if (sale_promotions[key] === 'active') {
                                $('#isactive_true').prop('checked', true);
                            } else {
                                $('#isactive_false').prop('checked', true);
                            }
                        }
                        else {
                            $('#form #' + key).val(sale_promotions[key]);
                        }
                    }
                });
            });

            $('#modal-create').on('hidden.bs.modal', function(event) {
                $("#form")[0].reset();
            })

            $('#modal-edit').on('hidden.bs.modal', function(event) {
                $("#form")[0].reset();
            })

            function validationData(){

                $('.invalid').html('');

                let status = true;

                if ( !$('#warehouse_id').val()) {
                    $('.invalid.warehouse_id').html('กรุณาเลือกคลังสินค้า');
                    status = false;
                }

                if ( !$('#product_id').val()) {
                    $('.invalid.product_id').html('กรุณาเลือกสินค้า');
                    status = false;
                }

                return status;
            }

            function addStorck(){
                const warehouse_id = $('#warehouse_select').val();

                let url = "{{ route('inventorystockadjustment.create') }}";
                if( warehouse_id>=1 ){
                    url = "{{ route('inventorystockadjustment.create', ['whid' => ':id']) }}";
                    url = url.replace('%3Aid', warehouse_id);
                }
                window.location.href = url;
            }

        </script>
    @endpush
    @include('admin.warehouse.inventory.partials.create-modal')
@endsection

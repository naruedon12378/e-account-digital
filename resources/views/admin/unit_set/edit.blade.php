@extends('adminlte::page')
@php $pagename = 'จัดการหน่วยสินค้าย่อย'; @endphp
@section('content')
    <div class="pt-3">
        @include('vendor.adminlte.partials.common.breadcrumb', ['pagename' => $pagename])
        <!-- <div class="row">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background-color: transparent;">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                        class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('member.index') }}"
                                    class="{{ env('TEXT_THEME') }}">จัดการข้อมูลสมาชิก</a></li>
                            <li class="breadcrumb-item active">{{ $pagename }}</li>
                        </ol>
                    </nav>
                </div> -->

        <form action="{{ $form_action }}" method="POST" id="form">
            @csrf
            @if ($action == 'edit')
                @method('PUT')
                <input type="hidden" name="id" id="id" value="{{ $unit_set->id }}">
            @else
                @method('POST')
            @endif
            <div class="card {{ env('CARD_THEME') }} card-outline">
                <div class="card-header" style="font-size: 20px;">
                    <div class="float-left">
                        {{ $pagename }}
                        <!-- <a href="#" class="btn btn-outline-success mb-2 ml-3" data-toggle="modal"
                                    data-target="#modal-import"><i class="fas fa-file-import mr-2"></i>
                                    {{ __('unit_set.import_salary_pay_run') }}
                                </a> -->
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                @include('vendor.adminlte.components.form.form-select', [
                                    'name' => 'unit_parent_id',
                                    'label' => 'unit_set.unit_parent',
                                    'isRequired' => true,
                                    'property' => '',
                                    'data' => $units->pluck('name_th', 'id'),
                                    'value' => old('unit_parent_id', $unit_parent_id),
                                    'class' => null,
                                ])
                                <span class="text-danger invalid">{{ $errors->first('unit_parent_id') }}</span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label class="form-label" for="description">{{ __('unit_set.description') }}</label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <hr />

                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                {{ __('unit_set.unit_child') }}
                                <a id="additem"
                                    class="btn btn-outline-success float-right">{{ __('unit_set.add_unit_child') }}</a>
                            </blockquote>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                                <thead class="bg-custom">
                                    <tr>
                                        <th class="text-center" style="width: 50px"></th>
                                        <th class="text-center">{{ __('unit_set.unit_child') }}
                                        </th>
                                        <th class="text-center" style="width: 200px">{{ __('unit_set.amount') }}</th>
                                        <th class="text-center" style="width: 100px">{{ __('unit_set.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($action == 'edit' || old('selected_units'))

                                        @php
                                            $selected_units = old('selected_units', $selected_units);
                                            $unit_amounts = old('unit_amounts', $unit_amounts);
                                        @endphp

                                        @foreach ($selected_units as $index => $selected_unit)
                                            <tr>
                                                <td>
                                                    <i class="fas fa-bars"></i>
                                                </td>
                                                <td>
                                                    <select name="selected_units[]" class="form-control select"
                                                        style="width: 100%">
                                                        <option value="-1" data-unit_child="0">
                                                            {{ __('home.please_select') }}</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->id }}"
                                                                {{ old('selected_units.' . $index, $selected_unit) == $unit->id ? 'selected' : '' }}>
                                                                {{ $unit->name_th }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger invalid units"></span>
                                                    <span
                                                        class="text-danger invalid">{{ $errors->first('selected_units.0') }}</span>
                                                </td>
                                                <td>
                                                    <input name="unit_amounts[]" type="number" class="form-control"
                                                        min="1"
                                                        value="{{ old('unit_amounts.' . $index, $unit_amounts[$index]) }}">
                                                    <span class="text-danger invalid amounts"></span>
                                                    <span
                                                        class="text-danger invalid">{{ $errors->first('unit_amounts.0') }}</span>
                                                </td>
                                                <td>
                                                    <a class="btn btn-danger removeitem"><i
                                                            class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                <i class="fas fa-bars"></i>
                                            </td>
                                            <td>
                                                <select name="selected_units[]" class="form-control select"
                                                    style="width: 100%">
                                                    <option value="-1" data-unit_child="0">
                                                        {{ __('home.please_select') }}</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}"
                                                            data-unit_child="{{ $unit->name_th }}">{{ $unit->name_th }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger invalid units"></span>
                                                <span
                                                    class="text-danger invalid">{{ $errors->first('selected_units.0') }}</span>
                                            </td>
                                            <td>
                                                <input name="unit_amounts[]" type="number" class="form-control"
                                                    min="1">
                                                <span class="text-danger invalid amounts"></span>
                                                <span
                                                    class="text-danger invalid">{{ $errors->first('unit_amounts.0') }}</span>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger removeitem"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="float-right">
                        <a class='btn btn-secondary' onclick='history.back();'><i
                                class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                        <a class="btn {{ env('BTN_THEME') }}" onclick="submitData()">
                            <span id="btn_submit_loading" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                            <i class="fas fa-save mr-2"></i> {{ __('home.save') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

<!-- @section('plugins.Thailand', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11']) -->
@push('js')
    <script>
        var table;

        function validationData() {

            $('.invalid').html('');

            let status = true;
            if ($('#unit_parent_id').val() == null || $('#unit_parent_id').val() == "") {
                $('.invalid.unit_parent_id').html('กรุณาเลือกกลุ่มสินค้าหลัก');
                status = false;
            }

            const input_selected_units = document.getElementsByName('selected_units[]');
            for (let i = 0; i < input_selected_units.length; i++) {
                if (input_selected_units[i].value == -1) {
                    $('.invalid.units').eq(i).html('กรุณาเลือกกลุ่มสินค้าย่อย');
                    status = false;
                }
            }

            const input_unit_amounts = document.getElementsByName('unit_amounts[]');
            for (let i = 0; i < input_unit_amounts.length; i++) {
                if (Number(input_unit_amounts[i].value) < 1) {
                    $('.invalid.amounts').eq(i).html('กรุณากำหนดจำนวนหน่วยย่อย');
                    status = false;
                }
            }

            return status;
        }

        function submitData() {

            if (!validationData()) {
                return;
            }

            $('.fas.fa-save').hide();
            $('#btn_submit_loading').show();
            $('#form').submit();
        }

        $(document).ready(function() {

            $('#btn_submit_loading').hide();

            table = $('#table').DataTable({
                // responsive: true,
                rowReorder: true,
                processing: true,
                scrollY: 450,
                scrollCollapse: true,
                paging: false,
                language: {
                    url: "{{ asset('plugins/DataTables/th.json') }}",
                },
                columnDefs: [{
                        className: 'text-center',
                        targets: [0, 3]
                    },
                    {
                        orderable: false,
                        targets: [0, 1, 2, 3]
                    },
                ],
                "dom": 'rtip',
            });

            $('#additem').on('click', function() {

                const ri = table.data().length;

                reOrder = "<i class='fas fa-bars'></i>"
                unit = `<select name="selected_units[]" class="form-control select" style="width: 100%">
                            <option value="-1" data-unit_child="0">{{ __('home.please_select') }}</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}"
                                    data-unit_child="{{ $unit->name_th }}">{{ $unit->name_th }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger invalid units"></span>`;
                amount = `<input name='unit_amounts[]' type='number' class='form-control min="1"'>
                            <span class="text-danger invalid amounts"></span>
                            <span class="text-danger invalid">{{ $errors->first('unit_amounts.1') }}</span>
                            `;
                btnDel = '<a class="btn btn-danger removeitem"><i class="fas fa-trash-alt"></i></a>'
                table.row.add([reOrder, unit, amount, btnDel]).draw(false);
            });

            $('#table tbody').on('click', '.removeitem', function() {
                table.row($(this).parents('tr')).remove().draw();
            })

        });
    </script>
@endpush
@endsection

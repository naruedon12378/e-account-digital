@extends('adminlte::page')
<style>
    .calSection {
        font-weight: bold;
        font-size: 1.2em;
        border: none;
        outline: none;
        background: transparent;
        pointer-events: none;
    }

    .dataTables_scrollBody {
        max-height: 700px !important;
        overflow-y: auto;
    }
</style>
@php
    $pagename = [
        'th' => 'เพิ่มการจ่ายเงินเดือน',
        'en' => 'Create Payroll Salary',
    ];
    $locale = app()->getLocale();
    $name = 'name_' . $locale;

    $currentDate = date('d/m/Y');
    $firstDate = date('01/m/Y');
    $endDate = date('t/m/Y');
    $dayOfPaid = $company_setting->day_of_paid_salary;
    $dueDate = $dayOfPaid == 0 ? $endDate : date(sprintf('%02d/m/Y', $dayOfPaid));
@endphp
@section('content')
    <div class="pt-3">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> {{ __('home.homepage') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payroll_salary.index') }}"
                            class="{{ env('TEXT_THEME') }}">{{ __('payroll_salary.head') }}</a></li>
                    <li class="breadcrumb-item active">{{ $pagename[$locale] }}</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('payroll_salary.store') }}" method="post" enctype="multipart/form-data" id="form">
            @csrf
            @foreach ($financial_records as $record)
                <input name="frecord[]" id="frecord" type="hidden" value="{{ $record->id }}">
            @endforeach
            <div class="card {{ env('CARD_THEME') }} card-outline">
                <div class="card-header" style="font-size: 20px;">
                    <div class="float-left">
                        {{ $pagename[$locale] }}
                        <a href="#" class="btn btn-outline-success mb-2 ml-3" data-toggle="modal"
                            data-target="#modal-import"><i class="fas fa-file-import mr-2"></i>
                            {{ __('payroll_salary.import_salary_pay_run') }}
                        </a>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                {{ __('payroll_salary.pay_run_period') }}
                            </blockquote>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label>{{ __('payroll_salary.issue_date') }}</label>
                            <input type="text" class="form-control  inputmask-date datepicker currentDate"
                                id="issue_date" name="issue_date">
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label>{{ __('payroll_salary.due_date') }}</label>
                            <input type="text" class="form-control  inputmask-date datepicker dueDate" id="due_date"
                                name="due_date">
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label>{{ __('payroll_salary.from_date') }}</label>
                            <input type="text" class="form-control  inputmask-date datepicker firstDate" id="from_date"
                                name="from_date">
                        </div>
                        <div class="col-sm-3 mb-3">
                            <label>{{ __('payroll_salary.to_date') }}</label>
                            <input type="text" class="form-control  inputmask-date datepicker endDate" id="to_date"
                                name="to_date">
                        </div>
                        <div class="col-sm-12">
                            <hr />
                        </div>
                        <div class="col-sm-12 mb-3">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                {{ __('payroll_salary.employees_receive_this_salary') }}
                                <a id="additem"
                                    class="btn btn-outline-success float-right">{{ __('payroll_salary.add_new_employee') }}</a>
                            </blockquote>

                        </div>
                        <div class="col-sm-12 mb-3 table-responsive" style="width: 100%; overflow-x: auto;">
                            <table id="table" class="table table-hover dataTable no-footer nowrap"
                                style="width: max-content;">
                                <thead class="bg-custom">
                                    <tr>
                                        <th class="text-center" style="width: 250px">{{ __('payroll_salary.name') }}
                                        </th>
                                        <th class="text-center" style="width: 150px">{{ __('payroll_salary.salary') }}</th>
                                        @foreach ($financial_records as $record)
                                            <th class="text-center" style="width: 150px">
                                                {{ $record->$name }}
                                            </th>
                                        @endforeach
                                        <th class="text-center" style="width: 150px">
                                            {{ __('payroll_salary.withholding_tax') }}</th>
                                        <th class="text-center" style="width: 150px">
                                            {{ __('payroll_salary.social_security') }}</th>
                                        @if ($company_setting->pvd_status == 1)
                                            <th class="text-center" style="width: 150px">
                                                {{ __('payroll_salary.pvd') }} ({{ $company_setting->pvd_rate }}%)</th>
                                        @endif
                                        <th class="text-center" style="width: 150px">
                                            {{ __('payroll_salary.total_revenue') }}
                                        </th>
                                        <th class="text-center" style="width: 150px">
                                            {{ __('payroll_salary.total_deduct') }}
                                        </th>
                                        <th class="text-center" style="width: 150px">{{ __('payroll_salary.net_salary') }}
                                        </th>
                                        <th class="text-center" style="width: 150px">{{ __('payroll_salary.actions') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="emp_rows">
                                        <td>
                                            <select name="employee[]" class="form-control select2" style="width: 250px">
                                                <option value="-1" data-salary="0">{{ __('home.please_select') }}
                                                </option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        data-salary="{{ $employee->salary }}"
                                                        data-social_security_status="{{ $employee->scc_chkbox }}">
                                                        {{ $employee->$name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input name="salary[]" style="width: 150px" type="number" step="0.01"
                                                value="0.00" class="form-control text-right numberInput calAdd">
                                        </td>
                                        @foreach ($financial_records as $key => $record)
                                            @php
                                                $type_account = 'calAdd';
                                                if ($record->type_account == 1) {
                                                    $type_account = 'calCut';
                                                }
                                            @endphp
                                            <td>
                                                <input name="frecord_{{ $key }}[]" style="width: 150px"
                                                    type="number" step="0.01" value="0.00"
                                                    class="form-control text-right numberInput {{ $type_account }}">
                                            </td>
                                        @endforeach
                                        <td>
                                            <input name="withholding_tax[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput calCut">
                                        </td>
                                        <td>
                                            <input name="social_security[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                max="{{ $company_setting->employees_maximum_amount }}"
                                                class="form-control text-right numberInput calCut">
                                        </td>
                                        @if ($company_setting->pvd_status == 1)
                                            <td>
                                                <input name="pvd[]" style="width: 150px" type="number" step="0.01"
                                                    value="0.00" class="form-control text-right numberInput calCut">
                                            </td>
                                        @endif
                                        <td>
                                            <input name="total_revenue[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput sumAdd">
                                        </td>
                                        <td>
                                            <input name="total_deduct[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput sumCut">
                                        </td>
                                        <td>
                                            <input name="net_salary[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput calTotal">
                                        </td>
                                        <td><a class="btn btn-danger removeitem"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <hr />
                        </div>
                        <div class="col-sm-12 mb-3">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                {{ __('payroll_salary.salary_pay_run_summary') }}
                            </blockquote>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-4 mb-3 text-right">{{ __('payroll_salary.total_salary') }}</div>
                                <div class="col-sm-8 mb-3 text-right">
                                    <input type="text" readonly class="calSection text-right total_salary_text"
                                        name="total_salary_text" value="0.00">
                                    {{ __('payroll_salary.baht') }}
                                </div>
                                <div class="col-sm-4 mb-3 text-right">
                                    <span class="text-success">{{ __('payroll_salary.add') }}</span>
                                    {{ __('payroll_salary.summary_of_revenue_items') }}
                                </div>
                                <div class="col-sm-8 mb-3 text-right">
                                    <input type="text" readonly class="calSection text-right total_revenue_text"
                                        name="total_revenue_text" value="0.00">
                                    {{ __('payroll_salary.baht') }}
                                </div>
                                <div class="col-sm-4 mb-3 text-right">
                                    <span class="text-danger">{{ __('payroll_salary.less') }}</span>
                                    {{ __('payroll_salary.summary_of_deduction_items') }}
                                </div>
                                <div class="col-sm-8 mb-3 text-right">
                                    <input type="text" readonly class="calSection text-right total_deduct_text"
                                        name="total_deduct_text" value="0.00">
                                    {{ __('payroll_salary.baht') }}
                                </div>
                                <div class="col-sm-4 mb-3 text-right">
                                    <span class="text-danger">{{ __('payroll_salary.less') }}</span>
                                    {{ __('payroll_salary.social_security') }}
                                </div>
                                <div class="col-sm-8 mb-3 text-right">
                                    <input type="text" readonly
                                        class="calSection text-right total_social_security_text"
                                        name="total_social_security_text" value="0.00">
                                    {{ __('payroll_salary.baht') }}
                                </div>
                                @if ($company_setting->pvd_status == 1)
                                    <div class="col-sm-4 mb-3 text-right">
                                        <span class="text-danger">{{ __('payroll_salary.less') }}</span>
                                        {{ __('payroll_salary.pvd') }}
                                    </div>
                                    <div class="col-sm-8 mb-3 text-right">
                                        <input type="text" readonly class="calSection text-right total_pvd_text"
                                            name="total_pvd_text" value="0.00">
                                        {{ __('payroll_salary.baht') }}
                                    </div>
                                @endif
                                <div class="col-sm-4 mb-3 text-right">
                                    <span class="text-danger">{{ __('payroll_salary.less') }}</span>
                                    {{ __('payroll_salary.withholding_tax') }}
                                </div>
                                <div class="col-sm-8 mb-3 text-right">
                                    <input type="text" readonly
                                        class="calSection text-right total_withholding_tax_text"
                                        name="total_withholding_tax_text" value="0.00">
                                    {{ __('payroll_salary.baht') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card shadow-custom bg-custom">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4">{{ __('payroll_salary.net_amount_to_pay') }}</div>
                                                <div class="col-sm-8 text-right">
                                                    <input type="text" readonly
                                                        class="amount_pay calSection w-50 text-white text-right"
                                                        name="amount_pay" value="0.00">
                                                    {{ __('payroll_salary.baht') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-3 text-right">
                                    {{ __('payroll_salary.social_security_employer') }}
                                </div>
                                <div class="col-sm-6 mb-3 text-right">
                                    <input name="company_social_security" style="width: 150px" type="number"
                                        step="0.01" value="0.00"
                                        class="form-control text-right w-100 numberInputEmpSocial">
                                </div>
                                <div class="col-sm-6 mb-3 text-right">
                                    <span class="text-danger">{{ __('payroll_salary.payable') }}</span>
                                    {{ __('payroll_salary.social_security') }}
                                </div>
                                <div class="col-sm-6 mb-3 text-right pr-4">
                                    <input type="text" readonly
                                        class="calSection text-right w-50 total_social_security_payable"
                                        name="total_social_security_payable" value="0.00">
                                    {{ __('payroll_salary.baht') }}
                                </div>
                                <div class="col-sm-6 mb-3 text-right">
                                    <span class="text-danger">{{ __('payroll_salary.payable') }}</span>
                                    {{ __('payroll_salary.withholding_tax') }}
                                </div>
                                <div class="col-sm-6 mb-3 text-right pr-4">
                                    <input type="text" readonly
                                        class="calSection text-right w-50 total_withholding_tax_payable"
                                        name="total_withholding_tax_payable" value="0.00">
                                    {{ __('payroll_salary.baht') }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a class='btn btn-secondary' onclick='history.back();'><i
                                class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                        <a class='btn btn-warning }}' data-action="0" onclick="submitData(this)"><i
                                class="fas fa-file-signature mr-2"></i>{{ __('payroll_salary.action_0') }}</a>
                        @if (Auth::user()->hasAnyPermission(['*', 'all payroll_salary', 'approve_payrun']))
                            <a class='btn {{ env('BTN_THEME') }}' data-action="1" onclick="submitData(this)"><i
                                    class="fas fa-check"></i>{{ __('payroll_salary.action_1') }}</a>
                            {{-- <a class='btn {{ env('BTN_THEME') }}' data-action="2" onclick="submitData(this)"><i
                                    class="fas fa-check-double mr-2"></i>{{ __('payroll_salary.action_2') }}</a> --}}
                        @endif
                        <a class='btn btn-info }}' data-action="3" onclick="submitData(this)"><i
                                class="fas fa-paper-plane mr-2"></i>{{ __('payroll_salary.action_3') }}</a>
                        <input type="hidden" name="action" id="action">
                    </div>
                </div>
            </div>
        </form>
    </div>

@section('plugins.Thailand', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])
@push('js')
    <script>
        var table;

        function submitData(element) {
            Swal.fire({
                title: '{{ __('home.alert_confirm_text') }}',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: '{{ __('home.close') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    if (table.data().length > 0) {
                        let action = $(element).data('action')
                        $('#action').val(action)
                        $('#form').submit();
                    } else {
                        alert('{{ __('payroll_salary.alert_count_tr') }}');
                    }
                }
            })
        }

        function calRow() {
            var closestRow = $(this).closest('tr');
            var salary_val = parseFloat(closestRow.find('input[name="salary[]"]').val());

            var employee_social_security_status = closestRow.find('option:selected').data('social_security_status');
            var company_social_security_status = '{{ $company_setting->social_security_status }}';
            var maxSocialValue = parseFloat('{{ $company_setting->employees_maximum_amount }}');
            var social_security_rate = parseFloat('{{ $company_setting->employees_social_security_rate }}');
            var pvd_status = '{{ $company_setting->pvd_status }}';
            var pvd_rate = parseFloat('{{ $company_setting->pvd_rate }}');
            var social_net = 0;
            var pvd_net = 0;

            if (company_social_security_status == 1) {
                if (employee_social_security_status == 1) {
                    social_net = salary_val * social_security_rate / 100;
                    if (social_net > maxSocialValue) {
                        social_net = maxSocialValue;
                    }
                }
            }

            var formattedSocial = social_net.toFixed(2);
            closestRow.find('input[name="social_security[]"]').val(formattedSocial);

            if (pvd_status == 1) {
                pvd_net = salary_val * pvd_rate / 100;
            }

            var formattedPVD = pvd_net.toFixed(2);
            closestRow.find('input[name="pvd[]"]').val(formattedPVD);

            var sumAdd = 0;
            var sumCut = 0;
            var calTotal = 0;

            closestRow.find('input.calAdd').each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    sumAdd += value;
                }
            });

            closestRow.find('input.calCut').each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    sumCut += value;
                }
            });

            calTotal = sumAdd - sumCut;

            closestRow.find('input[name="total_revenue[]"]').val(sumAdd.toFixed(2));
            closestRow.find('input[name="total_deduct[]"]').val(sumCut.toFixed(2));
            closestRow.find('input[name="net_salary[]"]').val(calTotal.toFixed(2));
        }

        function calTotal() {
            var salary_all = $('input[name="salary[]"]');
            var total_revenue_all = $('input[name="total_revenue[]"]');
            var total_deduct_all = $('input[name="total_deduct[]"]');
            var withholding_tax_all = $('input[name="withholding_tax[]"]');
            var social_security_all = $('input[name="social_security[]"]');
            var pvd_all = $('input[name="pvd[]"]');
            var company_social_security = parseFloat($('input[name="company_social_security"]').val());

            var total_salary = 0;
            var total_revenue = 0;
            var total_deduct = 0;
            var total_withholding_tax = 0;
            var total_social_security = 0;
            var total_pvd = 0;

            salary_all.each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total_salary += value;
                }
            });

            withholding_tax_all.each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total_withholding_tax += value;
                }
            });

            social_security_all.each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total_social_security += value;
                }
            });

            pvd_all.each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total_pvd += value;
                }
            });

            total_revenue_all.each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total_revenue += value;
                }
            });
            total_revenue = total_revenue - total_salary;

            total_deduct_all.each(function() {
                var value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total_deduct += value;
                }
            });
            total_deduct = total_deduct - total_withholding_tax - total_social_security;

            var total_social_security_payable = total_social_security + company_social_security
            var amount_pay = (total_salary + total_revenue) - (total_deduct + total_social_security +
                total_withholding_tax)

            $('.total_salary_text').val(formatter2Digit.format(total_salary))
            $('.total_withholding_tax_text').val(formatter2Digit.format(total_withholding_tax))
            $('.total_social_security_text').val(formatter2Digit.format(total_social_security))
            $('.total_pvd_text').val(formatter2Digit.format(total_pvd))
            $('.total_revenue_text').val(formatter2Digit.format(total_revenue))
            $('.total_deduct_text').val(formatter2Digit.format(total_deduct))
            $('.total_social_security_payable').val(formatter2Digit.format(total_social_security_payable))
            $('.total_withholding_tax_payable').val(formatter2Digit.format(total_withholding_tax))
            $('.amount_pay').val(formatter2Digit.format(amount_pay))

        }

        $(document).ready(function() {
            table = $('#table').DataTable({
                rowReorder: false,
                processing: true,
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                fixedHeader: true,
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                },
                language: {
                    url: "{{ asset('plugins/DataTables/th.json') }}",
                },
                columnDefs: [],
                "dom": 'rtip',
            });

            $('#additem').on('click', function() {
                var newRowHtml = `
                                    <tr>
                                        <td>
                                            <select name="employee[]" class="form-control select2" style="width: 250px">
                                                <option value="-1" data-salary="0">{{ __('home.please_select') }}
                                                </option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        data-salary="{{ $employee->salary }}" data-social_security_status="{{ $employee->scc_chkbox }}">{{ $employee->$name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input name="salary[]" style="width: 150px" type="number" step="0.01"
                                                value="0.00" class="form-control text-right numberInput calAdd">
                                        </td>
                                        @foreach ($financial_records as $key => $record)
                                            @php
                                                $type_account = 'calAdd';
                                                if ($record->type_account == 1) {
                                                    $type_account = 'calCut';
                                                }
                                            @endphp
                                            <td>
                                                <input name="frecord_{{ $key }}[]" style="width: 150px"
                                                    type="number" step="0.01" value="0.00"
                                                    class="form-control text-right numberInput {{ $type_account }}">
                                            </td>
                                        @endforeach
                                        <td>
                                            <input name="withholding_tax[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput calCut">
                                        </td>
                                        <td>
                                            <input name="social_security[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                max="{{ $company_setting->employees_maximum_amount }}"
                                                class="form-control text-right numberInput calCut">
                                        </td>
                                        @if ($company_setting->pvd_status == 1)
                                            <td>
                                                <input name="pvd[]" style="width: 150px" type="number" step="0.01"
                                                    value="0.00" class="form-control text-right numberInput calCut">
                                            </td>
                                        @endif
                                        <td>
                                            <input name="total_revenue[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput sumAdd">
                                        </td>
                                        <td>
                                            <input name="total_deduct[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput sumCut">
                                        </td>
                                        <td>
                                            <input name="net_salary[]" style="width: 150px" type="number"
                                                step="0.01" value="0.00"
                                                class="form-control text-right numberInput calTotal">
                                        </td>
                                        <td><a class="btn btn-danger removeitem"><i class="fas fa-trash-alt"></i></a></td>
                                    </tr>
                                `;
                var newRow = table.row.add($(newRowHtml)).draw(false).node();
                $(newRow).find('.select2').select2();
                value = 0;
                $('.numberInputEmpSocial').val(value.toFixed(2))
            });

            $('#table tbody').on('click', '.removeitem', function() {
                table.row($(this).parents('tr')).remove().draw();
                value = 0;
                $('.numberInputEmpSocial').val(value.toFixed(2))
            })

            $(document).on('change', 'select[name="employee[]"]', function() {
                var selectedSalary = $(this).find('option:selected').data('salary');
                var formattedSalary = selectedSalary.toFixed(2);
                var input = $(this).closest('tr').find('input[name="salary[]"]');
                input.val(formattedSalary);
                calRow.call(this);
                calTotal();
            });

            $('table').on('input change mouseenter mouseleave focus', 'tr input', function() {
                calRow.call(this);
                calTotal();
            });

            $(document).on('change input', 'input[name="company_social_security"]', function() {
                calTotal();
            });

            $('.numberInput').on('input change', function() {
                var value = parseFloat($(this).val());
                var max = parseFloat($(this).attr('max'));

                if (!isNaN(value)) {
                    if (!isNaN(max) && value > max) {
                        $(this).val(max.toFixed(2));
                    } else {
                        $(this).val(value.toFixed(2));
                    }
                }
            });

            $('.numberInputEmpSocial').on('input change', function() {
                var value = parseFloat($(this).val());
                var max = "{{ $company_setting->employers_maximum_amount }}";
                var countEmp = $('input[name="social_security[]"]').length
                var calMax = parseFloat(max * countEmp);

                if (!isNaN(value)) {
                    if (!isNaN(calMax) && value > calMax) {
                        $(this).val(calMax.toFixed(2));
                    } else {
                        $(this).val(value.toFixed(2));
                    }
                }
            });

            $(document).on('change', 'input[name="social_security[]"]', function() {
                var maxValue = parseFloat('{{ $company_setting->employees_maximum_amount }}');
                var enteredValue = parseFloat($(this).val());
                if (enteredValue > maxValue) {
                    $(this).val(maxValue.toFixed(2));
                }
            });

            var currentDate = "{{ $currentDate }}";
            var firstDate = "{{ $firstDate }}";
            var endDate = "{{ $endDate }}";
            var dayOfPaid = "{{ $dayOfPaid }}";
            var dueDate = "{{ $dueDate }}";

            $('.currentDate').val(currentDate);
            $('.firstDate').val(firstDate);
            $('.endDate').val(endDate);
            $('.dueDate').val(dueDate);

            $('#form').submit(function(event) {
                var selectedValues = [];
                var hasDuplicate = false;
                var invalidValue = '-1';

                $('select[name="employee[]"]').each(function() {
                    var value = $(this).val();
                    if (value) {
                        if (selectedValues.includes(value)) {
                            hasDuplicate = true;
                            alert('{{ __('payroll_salary.alert_select_checking2') }}');
                            return false;
                        } else if (value === invalidValue) {
                            hasDuplicate = true;
                            alert('{{ __('payroll_salary.alert_select_checking1') }}');
                            return false;
                        }
                        selectedValues.push(value);
                    }
                });

                if (hasDuplicate) {
                    event
                        .preventDefault(); // Prevent form submission if duplicates or invalid values are found
                }
            });
        });
    </script>
@endpush

@include('admin.payroll_salary.partials.import-modal')
@endsection

@extends('adminlte::page')
@php
    $pagename = 'แสดงข้อมูลรายการ';
    $pagename = [
        'th' => 'แสดงข้อมูลรายการ',
        'en' => 'Payroll Salary',
    ];
    $locale = app()->getLocale();
    $name = 'name_' . $locale;
@endphp
<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 20px;
    }

    .card {
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #dee2e6;
    }

    .nav-tabs .nav-link {
        border: none;
        color: #555;
    }

    .nav-tabs .nav-link.active {
        border-bottom: 2px solid #007bff;
        color: #007bff;
    }

    .tab-content {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-top: none;
        padding: 20px;
    }

    .btn-primary,
    .btn-danger,
    .btn-success {
        margin-right: 10px;
    }

    .info-section {
        margin-bottom: 20px;
    }

    .info-section .row {
        margin-bottom: 10px;
    }

    .info-section .col-md-6 {
        font-size: 14px;
    }

    .table-responsive {
        margin-bottom: 20px;
    }

    .summary-section {
        font-size: 14px;
    }

    .badge-info {
        background-color: #17a2b8;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody tr td {
        vertical-align: middle;
    }

    .text-right strong {
        color: #007bff;
    }

    .download-links a {
        display: block;
    }

    .download-links a:not(:last-child) {
        margin-bottom: 10px;
    }

    .btn-payroll {
        margin-top: 20px;
    }

    .timeline {
        position: relative;
        padding: 21px 0 10px;
        list-style: none;
    }

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 2px;
        background-color: #dee2e6;
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline-item {
        margin-bottom: 20px;
        position: relative;
    }

    .timeline-item:before,
    .timeline-item:after {
        content: "";
        display: table;
    }

    .timeline-item:after {
        clear: both;
    }

    .timeline-item .timeline-point {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 100%;
        background-color: #fff;
        border: 1px solid #007bff;
        top: 10px;
        left: 50%;
        margin-left: -5px;
        z-index: 1;
    }

    .timeline-item .timeline-content {
        margin-left: 70px;
        margin-right: 0;
        margin-top: 0;
        padding: 20px;
        background: #fff;
        border-radius: .25rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, .15);
        position: relative;
    }

    .timeline-item .timeline-date {
        position: absolute;
        left: -140px;
        top: 10px;
        font-size: 14px;
        color: #6c757d;
        text-align: right;
    }

    .timeline-item .timeline-icon {
        position: absolute;
        left: -60px;
        top: 0;
        font-size: 24px;
        color: #6c757d;
    }

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
        <x-form-card>
            <x-form-tabs :tabs="$tabs">
                <x-tab-content id="detail" active>
                    @php
                        $statusTextArray = [
                            'th' => ['แบบร่าง', 'รออนุมัติ', 'รอชำระ', 'ชำระแล้ว', 'ถังขยะ'],
                            'en' => ['Draft', 'Await Approval', 'Outstanding', 'Paid', 'Voided'],
                            'color' => ['warning', 'info', 'secondary', 'success', 'danger'],
                        ];
                        $status = $statusTextArray[$locale][$payroll_salary->status];
                        $color = $statusTextArray['color'][$payroll_salary->status];
                        $number = $payroll_salary->code;
                        $header_paper =
                            ' <h5> ' .
                            __('payroll_salary.Pay_Run') .
                            ' # ' .
                            $number .
                            '</h5><span class="badge badge-' .
                            $color .
                            ' p-1 px-2 mb-2" style="font-size:14px">' .
                            $status .
                            '</span>';
                    @endphp
                    {!! $header_paper !!}
                    <div class="info-section">
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                    {{ __('payroll_salary.General_Info') }}
                                </blockquote>
                            </div>
                            <div class="col-md-4">
                                <strong>{{ __('contact.company_name') }}</strong><br>{{ $payroll_salary->company->$name }}
                            </div>
                            <div class="col-md-4">
                                <strong>{{ __('payroll_salary.number_of_employee') }}</strong><br>{{ $payroll_salary->emp_count }}
                                คน
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                                <strong>{{ __('payroll_salary.cycle_date') }}</strong><br>{{ date('d/m/Y', strtotime($payroll_salary->from_date)) }}
                                -
                                {{ date('d/m/Y', strtotime($payroll_salary->to_date)) }}
                            </div>
                            <div class="col-md-4">
                                <strong>{{ __('payroll_salary.issue_date') }}</strong><br>{{ date('d/m/Y', strtotime($payroll_salary->issue_date)) }}
                            </div>
                            <div class="col-md-4">
                                <strong>{{ __('payroll_salary.due_date') }}</strong><br>{{ date('d/m/Y', strtotime($payroll_salary->due_date)) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <hr />
                    </div>
                    <div class="table-responsive">
                        <div class="col-sm-12 mb-3">
                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                {{ __('payroll_salary.EmpCount') }}
                            </blockquote>
                        </div>
                        <table class="table table-bordered" id="table">
                            <thead>
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
                                    @if ($payroll_salary->company->pvd_status == 1)
                                        <th class="text-center" style="width: 150px">
                                            {{ __('payroll_salary.pvd') }}</th>
                                    @endif
                                    <th class="text-center" style="width: 150px">
                                        {{ __('payroll_salary.total_revenue') }}
                                    </th>
                                    <th class="text-center" style="width: 150px">
                                        {{ __('payroll_salary.total_deduct') }}
                                    </th>
                                    <th class="text-center" style="width: 150px">{{ __('payroll_salary.net_salary') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <div class="summary-section row">
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
                                    <input type="text" readonly class="calSection text-right total_social_security_text"
                                        name="total_social_security_text" value="0.00">
                                    {{ __('payroll_salary.baht') }}
                                </div>
                                @if ($payroll_salary->company->pvd_status == 1)
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
                                    <input type="text" readonly class="calSection text-right total_withholding_tax_text"
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
                                <div class="col-sm-6 mb-3 text-right pr-4">
                                    <input type="text" readonly
                                        class="calSection text-right w-50 company_social_security"
                                        name="company_social_security" value="0.00">
                                    {{ __('payroll_salary.baht') }}
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
                </x-tab-content>
                <x-tab-content id="payment">
                    {!! $header_paper !!}
                    <div class="info-section">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>เงินเดือนสุทธิ:</strong>
                                <p class="mb-1"><small>0.00 </small>บาท</p>
                                <strong>จำนวนเงินสมทบประกันสังคม (นายจ้าง)::</strong>
                                <p class="mb-1"><small>0.00 </small>บาท</p>
                                <strong>จำนวนเงินสมทบประกันสังคม (ลูกจ้าง)::</strong>
                                <p class="mb-1"><small>0.00 </small>บาท</p>
                                <strong>จำนวนเงินภาษีหัก ณ ที่จ่ายรวม::</strong>
                                <p class="mb-1"><small>0.00 </small>บาท</p>
                            </div>
                            <div class="col-md-6"><strong class="mt-3">ดาวน์โหลด</strong>
                                <div class="download-links">
                                    <a href="#">ไฟล์จ่ายเงินธนาคาร</a>
                                    <a href="#">ไฟล์ประกันสังคม</a>
                                    <a href="#">ไฟล์ยื่นภาษี ภ.ง.ด.1 RD Prep</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-outline-info btn-custom">{{ __('home.save') }}ค้างจ่าย</button>
                    <button class="btn btn-info btn-custom">ชำระประกันสังคม</button>
                    <button class="btn btn-success btn-custom">ชำระเงินเดือน</button>
                </x-tab-content>
                <x-tab-content id="history">
                    <x-history :doc="$payroll_salary->code" :histories="$histories"></x-history>
                </x-tab-content>
            </x-form-tabs>
        </x-form-card>
    </div>

@section('plugins.Thailand', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])
@push('js')
    <script>
        $(document).ready(function() {
            table = $('#table').DataTable({
                rowReorder: false,
                ordering: false,
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
                "dom": '',
            });

            constructData();
        });

        function constructData() {
            let total = "{{ $payroll_salary->total }}"
            let sum_revenue_item = "{{ $payroll_salary->sum_revenue_item }}"
            let sum_deduct_item = "{{ $payroll_salary->sum_deduct_item }}"
            let employee_social_security = "{{ $payroll_salary->employee_social_security }}"
            let sum_holding_tax = "{{ $payroll_salary->sum_holding_tax }}"
            let company_social_security = "{{ $payroll_salary->company_social_security }}"
            let payable_social_security = "{{ $payroll_salary->payable_social_security }}"
            let payable_holding_tax = "{{ $payroll_salary->payable_holding_tax }}"
            let net_amount = "{{ $payroll_salary->net_amount }}"
            let pvd = "{{ $payroll_salary->pvd }}"

            $('.total_salary_text').val(formatter2Digit.format(total))
            $('.total_revenue_text').val(formatter2Digit.format(sum_revenue_item))
            $('.total_revenue_text').val(formatter2Digit.format(sum_revenue_item))
            $('.total_deduct_text').val(formatter2Digit.format(sum_deduct_item))
            $('.total_social_security_text').val(formatter2Digit.format(employee_social_security))
            $('.total_withholding_tax_text').val(formatter2Digit.format(sum_holding_tax))
            $('.company_social_security').val(formatter2Digit.format(company_social_security))
            $('.total_social_security_payable').val(formatter2Digit.format(payable_social_security))
            $('.total_withholding_tax_payable').val(formatter2Digit.format(payable_holding_tax))
            $('.amount_pay').val(formatter2Digit.format(net_amount))
            $('.total_pvd_text').val(formatter2Digit.format(pvd))

            table.clear().draw()
            let financialRecords = JSON.parse(
                '{!! $financial_records !!}');
            let payrollSalaryDetail = JSON.parse(
                '{!! $payroll_salary->payrollSalaryDetails !!}');

            $.each(payrollSalaryDetail, function(index, employee) {
                let dynamicRecords = "";
                $.each(employee['payroll_salary_more_details'], function(key, record) {
                    var typeAccount = 'calAdd';
                    if (record.payroll_financial_record.type_account == 1) {
                        typeAccount = 'calCut';
                    }
                    var inputElement = `
                                            <td class="text-right">
                                                ${formatter2Digit.format(record['value'])}
                                            </td>
                                        `;
                    dynamicRecords += inputElement
                });
                var newRowHtml = `
                                                <tr>
                                                    <td>
                                                        ${employee['employee']['fullname']['{{ $name }}']}
                                                    </td>
                                                    <td class="text-right">
                                                        ${formatter2Digit.format(employee['salary'])}
                                                    </td>
                                                    ${dynamicRecords}
                                                    <td class="text-right">
                                                       ${formatter2Digit.format(employee['withholding_tax']) }
                                                    </td>
                                                    <td class="text-right">
                                                        ${formatter2Digit.format(employee['social_security'])}
                                                    </td>
                                                    @if ($payroll_salary->company->pvd_status == 1)
                                                        <td class="text-right">
                                                            ${formatter2Digit.format(employee['pvd'])}
                                                        </td>
                                                    @endif
                                                    <td class="text-right">
                                                        ${formatter2Digit.format(employee['total_revenue'])}
                                                    </td>
                                                    <td class="text-right">
                                                        ${formatter2Digit.format(employee['total_deduct'])}
                                                    </td>
                                                    <td class="text-right">
                                                        ${formatter2Digit.format(employee['net_salary'])}
                                                    </td>
                                                </tr>
                                            `;
                var newRow = table.row.add($(newRowHtml)).draw(
                        false)
                    .node();
                $(newRow).find('.select2').select2();
                $(newRow).find('.select2').val(employee['employee_id']).change()
            })
        }
    </script>
@endpush
@endsection

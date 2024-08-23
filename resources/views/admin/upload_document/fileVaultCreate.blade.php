@extends('adminlte::page')
@php $pagename = __('uploadDocument.file_vault') @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="contrainer p-2">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="#" onclick="history.back()"
                            class="{{ env('TEXT_THEME') }}">อัพโหลดเอกสาร</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>

        <form method="post" action="#" enctype="multipart/form-data" id="form">
            @csrf
            <div class="card {{ env('CARD_THEME') }} card-outline shadow-custom">
                <div class="card-header">
                    <span style="font-size: 20px;">{{ $pagename }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <object data="{{ asset('documents/pdf-test.pdf') }}" type="application/pdf" width="100%"
                                style="height: 1000px !important;">
                            </object>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="row">
                                <div class="col-sm-12 mb-3">
                                    <div class="card shadow-custom">
                                        <div class="card-header" style="border-bottom: none;">
                                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                                {{ __('uploadDocument.record_transaction') }}

                                                <div class="ml-3 float-right">
                                                    <div class="icheck-primary icheck-inline">
                                                        <input type="radio" name="type_form" id="create_new_form"
                                                            value="create_new" checked />
                                                        <label
                                                            for="create_new_form">{{ __('uploadDocument.create_new') }}</label>
                                                    </div>
                                                    <div class="icheck-primary icheck-inline">
                                                        <input type="radio" name="type_form"
                                                            id="attach_to_the_document_form"
                                                            value="attach_to_the_document" />
                                                        <label
                                                            for="attach_to_the_document_form">{{ __('uploadDocument.attach_to_the_document') }}</label>
                                                    </div>
                                                </div>
                                            </blockquote>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <label for="" class="form-label">
                                                        {{ __('uploadDocument.document_type') }}</label>
                                                    <select name="document_type" id="document_type"
                                                        class="form-control select2" style="width: 100%;">
                                                        <option value="expense_record">
                                                            {{ __('uploadDocument.expense_record') }}
                                                        </option>
                                                        <option value="purchase_inventory_record">
                                                            {{ __('uploadDocument.purchase_inventory_record') }}</option>
                                                        <option value="purchase_asset">
                                                            {{ __('uploadDocument.purchase_asset') }}
                                                        </option>
                                                        <option value="quotation">{{ __('uploadDocument.quotation') }}
                                                        </option>
                                                        <option value="invoice">{{ __('uploadDocument.invoice') }}</option>
                                                        <option value="receipt">{{ __('uploadDocument.receipt') }}</option>
                                                        <option value="withheld_tax">
                                                            {{ __('uploadDocument.withheld_tax') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Create New --}}
                                <div class="col-sm-12 mb-3 create_new_area">
                                    {{-- Contact And Document --}}
                                    <div class="card shadow-custom">
                                        <div class="card-header" style="border-bottom: none;">
                                            <button type="button" class="btn btn-tool float-right mt-1"
                                                data-card-widget="collapse">
                                                {{ __('payroll_employee.show_less') }}
                                            </button>
                                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                                {{ __('uploadDocument.contact_and_document') }}
                                            </blockquote>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 mb-3">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.customer_seller') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%;">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mb-3">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.issue_date') }}</label>
                                                    <input type="text" class="form-control  inputmask-date datepicker">
                                                </div>
                                                <div class="col-sm-3 mb-3">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.pricing_type') }}</label>
                                                    <input type="text" class="form-control  inputmask-date datepicker">
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" name="type_form"
                                                            id="received_tax_invoice_chkbox" />
                                                        <label
                                                            for="received_tax_invoice_chkbox">{{ __('uploadDocument.received_tax_invoice') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mb-3">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.tax_invoice_no') }}</label>
                                                    <input type="text" id="tax_invoice_no" name="tax_invoice_no"
                                                        class="form-control  inputmask-date datepicker" disabled>
                                                </div>
                                                <div class="col-sm-3 mb-3">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.tax_invoice_date') }}</label>
                                                    <input type="text" id="tax_invoice_date" name="tax_invoice_date"
                                                        class="form-control  inputmask-date datepicker" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Contact And Document --}}

                                    {{-- Item --}}
                                    <div class="card shadow-custom">
                                        <div class="card-header" style="border-bottom: none;">
                                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                                {{ __('uploadDocument.item') }}
                                                <a id="additem_table_item"
                                                    class="btn btn-outline-success float-right">{{ __('uploadDocument.add_new_item') }}</a>
                                            </blockquote>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 mb-3">
                                                    <table id="table_item"
                                                        class="table table-hover dataTable no-footer nowrap"
                                                        style="width: 100%;">
                                                        <thead class="bg-custom">
                                                            <tr>
                                                                <th class="text-center" style="width: 5%"></th>
                                                                <th class="text-center">
                                                                    {{ __('uploadDocument.account') }}
                                                                </th>
                                                                <th class="text-center">
                                                                    {{ __('uploadDocument.description') }}
                                                                </th>
                                                                <th class="text-center" style="width: 10%">
                                                                    {{ __('uploadDocument.price') }}</th>
                                                                <th class="text-center" style="width: 10%">
                                                                    {{ __('uploadDocument.vat') }}
                                                                </th>
                                                                <th class="text-center" style="width: 10%">
                                                                    {{ __('uploadDocument.pre_vat') }}
                                                                </th>
                                                                <th class="text-center" style="width: 10%">
                                                                    {{ __('uploadDocument.wht') }}
                                                                </th>
                                                                <th class="text-center" style="width: 5%">
                                                                    {{ __('uploadDocument.actions') }}
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <i class="fas fa-bars"></i>
                                                                </td>
                                                                <td>
                                                                    <select name="account[]" class="form-control select2"
                                                                        style="width: 100%">
                                                                        <option></option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input name="description[]" type="text"
                                                                        class="form-control ">
                                                                </td>
                                                                <td>
                                                                    <input name="price[]" type="number"
                                                                        class="form-control ">
                                                                </td>
                                                                <td>
                                                                    <select name="vat[]" class="form-control select2"
                                                                        style="width: 100%">
                                                                        <option>None</option>
                                                                        <option>7%</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input name="vat[]" type="number"
                                                                        class="form-control ">
                                                                </td>
                                                                <td>
                                                                    <select name="wht[]" class="form-control select2"
                                                                        style="width: 100%">
                                                                    </select>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="float-right form-inline">
                                                        <label
                                                            class="form-label pr-2">{{ __('uploadDocument.net_total') }}</label>
                                                        <input type="text" class="form-control  text-right mx-2"
                                                            id="" value="100.00" readonly
                                                            aria-describedby="currencyInline">
                                                        <span id="currencyInline" class="text-muted">
                                                            {{ __('uploadDocument.thb') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-inline float-right">
                                                        <input type="checkbox" name="quotation_discount_chkbox"
                                                            class="mr-2" id="quotation_discount_chkbox" />
                                                        <label
                                                            class="form-label pr-2">{{ __('uploadDocument.quotation_discount') }}</label>
                                                        <input type="text" class="form-control  text-right mx-2"
                                                            id="quotation_discount" value="" readonly
                                                            aria-describedby="currencyInline">
                                                        <span id="currencyInline" class="text-muted">
                                                            {{ __('uploadDocument.thb') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-inline float-right">
                                                        <label
                                                            class="form-label pr-2">{{ __('uploadDocument.vat_exempted_amount') }}</label>
                                                        <input type="text" class="form-control  text-right mx-2"
                                                            id="" value="" readonly
                                                            aria-describedby="currencyInline">
                                                        <span id="currencyInline" class="text-muted">
                                                            {{ __('uploadDocument.thb') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-inline float-right">
                                                        <label
                                                            class="form-label pr-2">{{ __('uploadDocument.vat0_amount') }}</label>
                                                        <input type="text" class="form-control  text-right mx-2"
                                                            id="" value="" readonly
                                                            aria-describedby="currencyInline">
                                                        <span id="currencyInline" class="text-muted">
                                                            {{ __('uploadDocument.thb') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-inline float-right">
                                                        <label
                                                            class="form-label pr-2">{{ __('uploadDocument.vat7_amount') }}</label>
                                                        <input type="text" class="form-control  text-right mx-2"
                                                            id="" value="" readonly
                                                            aria-describedby="currencyInline">
                                                        <span id="currencyInline" class="text-muted">
                                                            {{ __('uploadDocument.thb') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3">
                                                    <div class="form-inline float-right">
                                                        <label
                                                            class="form-label pr-2">{{ __('uploadDocument.vat_amount') }}</label>
                                                        <input type="text" class="form-control  text-right mx-2"
                                                            id="" value="" readonly
                                                            aria-describedby="currencyInline">
                                                        <span id="currencyInline" class="text-muted">
                                                            {{ __('uploadDocument.thb') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- End Item --}}

                                    {{-- Payment --}}
                                    <div class="card collapsed-card shadow-custom">
                                        <div class="card-header" style="border-bottom: none;">
                                            <button type="button" class="btn btn-tool float-right mt-1"
                                                data-card-widget="collapse">
                                                {{ __('uploadDocument.add_payment') }}
                                            </button>
                                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                                {{ __('uploadDocument.payment') }}
                                            </blockquote>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <label
                                                        class="text-md mr-3">{{ __('uploadDocument.payment_record_no1') }}</label>
                                                    <div class="icheck-primary icheck-inline">
                                                        <input type="radio" name="type_form_payment"
                                                            id="basic_payment_form" value="basic" checked />
                                                        <label
                                                            for="basic_payment_form">{{ __('uploadDocument.basic') }}</label>
                                                    </div>
                                                    <div class="icheck-primary icheck-inline">
                                                        <input type="radio" name="type_form_payment"
                                                            id="advance_payment_form" value="advance" />
                                                        <label
                                                            for="advance_payment_form">{{ __('uploadDocument.advance') }}</label>
                                                    </div>

                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-inline float-right">
                                                        <label
                                                            class="form-label pr-2">{{ __('uploadDocument.payment_date') }}</label>
                                                        <input type="text" class="form-control  text-right">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <hr />
                                                </div>
                                                {{-- Payment Method --}}
                                                <div class="col-sm-12">
                                                    <div class="icheck-primary icheck-inline">
                                                        <input type="checkbox" name="payment_method_chkbox"
                                                            id="payment_method_chkbox" checked />
                                                        <label
                                                            for="payment_method_chkbox">{{ __('uploadDocument.payment_method') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mt-3 payment_method_form">
                                                    <label class="form-label"
                                                        for="">{{ __('uploadDocument.pay_from') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_method_form">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.payment_amount') }}</label>
                                                    <input type="number" class="form-control ">
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_method_form">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.remark') }}</label>
                                                    <input type="text" class="form-control ">
                                                </div>
                                                <div class="col-sm-12 mt-3 add_new_payment_method" style="display: none;">
                                                    <a href="#" class="text-primary"><i
                                                            class="fas fa-plus mr-2"></i>{{ __('uploadDocument.add_new_payment_method') }}</a>
                                                </div>
                                                {{-- End Payment Method --}}
                                                <div class="col-sm-12">
                                                    <hr />
                                                </div>
                                                {{-- Payment Fee and Adjustment --}}
                                                <div class="col-sm-12 advance_form" style="display: none;">
                                                    <div class="icheck-primary icheck-inline">
                                                        <input type="checkbox" name="fee_and_adjustment_chkbox"
                                                            id="fee_and_adjustment_chkbox" />
                                                        <label
                                                            for="fee_and_adjustment_chkbox">{{ __('uploadDocument.fee_and_adjustment') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_fee_and_adjustment_form"
                                                    style="display: none;">
                                                    <label class="form-label"
                                                        for="">{{ __('uploadDocument.adjusted_by') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_fee_and_adjustment_form"
                                                    style="display: none;">
                                                    <label class="form-label"
                                                        for="">{{ __('uploadDocument.record_to_account') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_fee_and_adjustment_form"
                                                    style="display: none;">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.adjusted_amount') }}</label>
                                                    <input type="number" class="form-control ">
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_fee_and_adjustment_form"
                                                    style="display: none;">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.remark') }}</label>
                                                    <input type="text" class="form-control ">
                                                </div>
                                                <div class="col-sm-12 mt-3 payment_fee_and_adjustment_form"
                                                    style="display: none;">
                                                    <a href="#" class="text-primary"><i
                                                            class="fas fa-plus mr-2"></i>{{ __('uploadDocument.add_new_fee_and_adjestment') }}</a>
                                                </div>
                                                {{-- End Payment Fee and Adjustment --}}
                                                <div class="col-sm-12 advance_form" style="display: none;">
                                                    <hr />
                                                </div>

                                                {{-- Payment Settle Payment --}}
                                                <div class="col-sm-12 advance_form" style="display: none;">
                                                    <div class="icheck-primary icheck-inline">
                                                        <input type="checkbox" name="settle_payment_chkbox"
                                                            id="settle_payment_chkbox" />
                                                        <label
                                                            for="settle_payment_chkbox">{{ __('uploadDocument.settle_payment_doc') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_settle_payment_form"
                                                    style="display: none;">
                                                    <label class="form-label"
                                                        for="">{{ __('uploadDocument.document_type') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_settle_payment_form"
                                                    style="display: none;">
                                                    <label class="form-label"
                                                        for="">{{ __('uploadDocument.document_no') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_settle_payment_form"
                                                    style="display: none;">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.payment_amount') }}</label>
                                                    <input type="number" class="form-control ">
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_settle_payment_form"
                                                    style="display: none;">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.remark') }}</label>
                                                    <input type="text" class="form-control ">
                                                </div>
                                                <div class="col-sm-12 mt-3 payment_settle_payment_form"
                                                    style="display: none;">
                                                    <a href="#" class="text-primary"><i
                                                            class="fas fa-plus mr-2"></i>{{ __('uploadDocument.settle_payment_doc') }}</a>
                                                </div>
                                                {{-- End Payment Settle Payment --}}
                                                <div class="col-sm-12 advance_form" style="display: none;">
                                                    <hr />
                                                </div>

                                                {{-- Payment Withholdinhg Tax --}}
                                                <div class="col-sm-12">
                                                    <div class="icheck-primary icheck-inline">
                                                        <input type="checkbox" name="withholding_tax_chkbox"
                                                            id="withholding_tax_chkbox" />
                                                        <label
                                                            for="withholding_tax_chkbox">{{ __('uploadDocument.withholding_tax') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_withholding_tax_form"
                                                    style="display: none;">
                                                    <label class="form-label"
                                                        for="">{{ __('uploadDocument.withholding_rate') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_withholding_tax_form"
                                                    style="display: none;">
                                                    <label class="form-label"
                                                        for="">{{ __('uploadDocument.pnd_type') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_withholding_tax_form"
                                                    style="display: none;">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.withheld_amount') }}</label>
                                                    <input type="number" class="form-control ">
                                                </div>
                                                <div class="col-sm-3 mt-3 payment_withholding_tax_form"
                                                    style="display: none;">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.tax_conditions') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%">
                                                        <option></option>
                                                    </select>
                                                </div>
                                                {{-- End Payment Withholding Tax --}}
                                                <div class="col-sm-12">
                                                    <hr />
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <div class="text-right">
                                                        {{ __('uploadDocument.total_adjustment') }}: <label
                                                            class="form-label pr-2">0.00
                                                            {{ __('uploadDocument.thb') }}</label>
                                                        <br />
                                                        {{ __('uploadDocument.settle_payment') }}: <label
                                                            class="form-label pr-2">0.00
                                                            {{ __('uploadDocument.thb') }}</label>
                                                        <br />
                                                        {{ __('uploadDocument.money_payment') }}: <label
                                                            class="form-label pr-2">0.00
                                                            {{ __('uploadDocument.thb') }}</label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 mb-3">
                                                    <br />
                                                    <div class="form-inline float-right">
                                                        <label
                                                            class="form-label pr-2">{{ __('uploadDocument.total_payment') }}</label>
                                                        <input type="text" class="form-control  text-right mx-2"
                                                            id="" value="" readonly
                                                            aria-describedby="currencyInline">
                                                        <span id="currencyInline" class="text-muted">
                                                            {{ __('uploadDocument.thb') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-3 text-right">
                                                    {{ __('uploadDocument.remaining_amount') }}: 0.00
                                                    {{ __('uploadDocument.thb') }}
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    {{-- End Payment --}}

                                    {{-- Tag --}}
                                    <div class="card shadow-custom">
                                        <div class="card-header" style="border-bottom: none;">
                                            <button type="button" class="btn btn-tool float-right mt-1"
                                                data-card-widget="collapse">
                                                {{ __('payroll_employee.show_less') }}
                                            </button>
                                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                                {{ __('uploadDocument.tag') }}
                                            </blockquote>
                                        </div>
                                        <div class="card-body">
                                            <textarea name="" id="" cols="30" rows="3" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    {{-- End Tag --}}
                                </div>

                                {{-- Attach To The Document --}}
                                <div class="col-sm-12 mb-3 attach_to_the_doc_area" style="display: none;">
                                    <div class="card shadow-custom">
                                        <div class="card-header" style="border-bottom: none;">
                                            <button type="button" class="btn btn-tool float-right mt-1"
                                                data-card-widget="collapse">
                                                {{ __('payroll_employee.show_less') }}
                                            </button>
                                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                                {{ __('uploadDocument.contact_and_document') }}
                                            </blockquote>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3 mb-3">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.customer_seller') }}</label>
                                                    <select name="" id="" class="form-control select2"
                                                        style="width: 100%;">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3 mb-3">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.from_date') }}</label>
                                                    <input type="text" class="form-control  inputmask-date datepicker">
                                                </div>
                                                <div class="col-sm-3 mb-3">
                                                    <label for=""
                                                        class="form-label">{{ __('uploadDocument.to_date') }}</label>
                                                    <input type="text" class="form-control  inputmask-date datepicker">
                                                </div>
                                                <div class="col-sm-3 mb-3 text-center mb-0 mt-auto">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-block">{{ __('uploadDocument.search') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Table  --}}
                                    <div class="card shadow-custom">
                                        <div class="card-header" style="border-bottom: none;">
                                            <button type="button" class="btn btn-tool float-right mt-1"
                                                data-card-widget="collapse">
                                                {{ __('payroll_employee.show_less') }}
                                            </button>
                                            <blockquote class="quote-success text-md" style="margin: 0 !important;">
                                                {{ __('uploadDocument.contact_and_document') }}
                                            </blockquote>
                                        </div>
                                        <div class="card-body">
                                            <table id="table" class="table table-hover dataTable no-footer nowrap"
                                                style="width: 100%;">
                                                <thead class="bg-custom">
                                                    <tr>
                                                        <th class="text-center" style="width: 10%">
                                                            {{ __('uploadDocument.doc_no') }}
                                                        </th>
                                                        <th class="text-center">
                                                            {{ __('uploadDocument.issue_date') }}
                                                        </th>
                                                        <th class="text-center">
                                                            {{ __('uploadDocument.amount') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="float-right">
                            <a class="btn btn-secondary" onclick="history.back();"><i
                                    class="fas fa-arrow-left mr-2"></i>{{ __('home.back') }}</a>
                            <button class="btn {{ env('BTN_THEME') }}" type="submit"><i
                                    class="fas fa-save mr-2"></i>{{ __('home.save') }}</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>

@section('plugins.Thailand', true)
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])
@push('js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script> --}}
    <script>
        $(document).ready(function() {
            var table_item = $('#table_item').DataTable({
                // responsive: true,
                rowReorder: true,
                processing: true,
                scrollY: 300,
                scrollCollapse: true,
                language: {
                    url: "{{ asset('plugins/DataTables/th.json') }}",
                },
                columnDefs: [{
                        className: 'text-center',
                        targets: [0, 7]
                    },
                    {
                        orderable: false,
                        targets: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                ],
                "dom": 'rtip',
            });

            $('#additem_table_item').on('click', function() {
                reOrder = "<i class='fas fa-bars'></i>"
                account =
                    "<select name='account[]' class='form-control select2' style='width: 100%'> <option></option></select>"
                description =
                    "<input name='description[]' type='text' class='form-control '>";
                price = "<input name='price[]' type='number' class='form-control '>";
                vat =
                    "<select name='vat[]' class='form-control select2' style='width: 100%'> <option>None</option> <option>7%</option></select>";
                pre_vat = "<input name='pre_vat[]' type='number' class='form-control '>";
                wht =
                    "<select name='wht[]' class='form-control select2' style='width: 100%'> <option></option></select>";
                btnDel =
                    '<a class="btn btn-danger removeitem_table_item"><i class="fas fa-trash-alt"></i></a>'
                table_item.row.add([reOrder, account, description, price, vat, pre_vat,
                    wht, btnDel
                ]).draw(false);
            });

            $('#table_item tbody').on('click', '.removeitem_table_item', function() {
                table_item.row($(this).parents('tr')).remove().draw();
            })

            var table = $('#table').DataTable({
                // responsive: true,
                rowReorder: true,
                processing: true,
                scrollY: 300,
                scrollCollapse: true,
                language: {
                    url: "{{ asset('plugins/DataTables/th.json') }}",
                },
                columnDefs: [{
                        className: 'text-center',
                        targets: [0, 1]
                    },
                    {
                        className: 'text-right',
                        targets: [0, 2]
                    },
                    {
                        orderable: false,
                        targets: [0, 1, 2]
                    },
                ],
                "dom": 'rtip',
            });
        });

        $("#received_tax_invoice_chkbox").on('change', function() {
            if (this.checked) {
                $('#tax_invoice_no').attr('disabled', false);
                $('#tax_invoice_date').attr('disabled', false);
            } else {
                $('#tax_invoice_no').attr('disabled', true);
                $('#tax_invoice_date').attr('disabled', true);
            }
        });

        $("input[name='type_form']").on('change', function() {
            chkFormType();
        });

        function chkFormType() {
            type = $("input[name='type_form']:checked").val();
            if (type === 'create_new') {
                $('.create_new_area').css('display', '');
                $('.attach_to_the_doc_area').css('display', 'none');
            } else {
                $('.create_new_area').css('display', 'none');
                $('.attach_to_the_doc_area').css('display', '');

                $('#table').DataTable().draw();
            }
        }

        $('#document_type').on('change', function() {
            if (this.value == 'expense_record' || this.value == 'purchase_inventory_record') {
                $('#create_new_form').attr('disabled', false);
            } else {
                $('#attach_to_the_document_form').prop('checked', true);
                $('#create_new_form').attr('disabled', true);
                chkFormType();
            }
        })

        $("#quotation_discount_chkbox").on('change', function() {
            if (this.checked) {
                $('#quotation_discount').attr('readonly', false);
            } else {
                $('#quotation_discount').attr('readonly', true);
            }
        });

        $("#payment_method_chkbox").on('change', function() {
            chkPaymentMethod();
            chkPaymentFormType();
        });

        function chkPaymentMethod() {
            if ($('#payment_method_chkbox').is(':checked')) {
                $('.payment_method_form').css('display', '');
            } else {
                $('.payment_method_form').css('display', 'none');
            }
        }

        $("#withholding_tax_chkbox").on('change', function() {
            chkPaymentWithholdingTax();
        });

        function chkPaymentWithholdingTax() {
            if ($('#withholding_tax_chkbox').is(':checked')) {
                $('.payment_withholding_tax_form').css('display', '');
            } else {
                $('.payment_withholding_tax_form').css('display', 'none');
            }
        }


        $("#fee_and_adjustment_chkbox").on('change', function() {
            chkPaymentFeeAndAdjustment();
        });

        function chkPaymentFeeAndAdjustment() {
            if ($('#fee_and_adjustment_chkbox').is(':checked')) {
                $('.payment_fee_and_adjustment_form').css('display', '');
            } else {
                $('.payment_fee_and_adjustment_form').css('display', 'none');
            }
        }

        $("#settle_payment_chkbox").on('change', function() {
            chkSettlePayment();
        });

        function chkSettlePayment() {
            if ($('#settle_payment_chkbox').is(':checked')) {
                $('.payment_settle_payment_form').css('display', '');
            } else {
                $('.payment_settle_payment_form').css('display', 'none');
            }
        }


        $("input[name='type_form_payment']").on('change', function() {
            chkPaymentFormType();
        });

        function chkPaymentFormType() {
            type = $("input[name='type_form_payment']:checked").val();

            if (type == 'advance') {
                // Payment Method
                if ($('#payment_method_chkbox').is(':checked')) {
                    $('.add_new_payment_method').css('display', '');
                } else {
                    $('.add_new_payment_method').css('display', 'none');
                }
                // End Payment Method

                // Fee and Adjustment
                if ($('#fee_and_adjustment_chkbox').is(':checked')) {
                    $('.payment_fee_and_adjustment_form').css('display', '');
                } else {
                    $('.payment_fee_and_adjustment_form').css('display', 'none');
                }
                // End Fee and Adjustment

                // Settle Payment
                if ($('#settle_payment_chkbox').is(':checked')) {
                    $('.payment_settle_payment_form').css('display', '');
                } else {
                    $('.payment_settle_payment_form').css('display', 'none');
                }
                // End Settle Payment

                $('.advance_form').css('display', '');
            } else {
                $('.add_new_payment_method').css('display', 'none');
                $('.payment_fee_and_adjustment_form').css('display', 'none');
                $('.payment_settle_payment_form').css('display', 'none');

                $('.advance_form').css('display', 'none');

            }
        }

        $('#form').submit(function() {
            if ($('#name_th').val() == null || $('#name_th').val() == "") {
                toastr.error('กรุณาใส่ชื่อหัวข้อภาษาไทย');
                return false;
            }

            if ($('#name_en').val() == null || $('#name_en').val() == "") {
                toastr.error('กรุณาใส่ชื่อหัวข้อภาษาอังกฤษ');
                return false;
            }
        });
    </script>
@endpush
@endsection

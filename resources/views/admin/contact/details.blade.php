@extends('adminlte::page')
@php($pagename = $contact?->party_name)
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    <x-form-card>
        <x-form-tabs :tabs="$tabs">
            <x-tab-content id="home" active>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h4>{{ $contact->party_name }}</h4>
                    <x-button-edit :url="route('contacts.edit', $contact->id)">
                        Edit
                    </x-button-edit>
                </div>
                <x-collapse number="1" title="Registration Information" show>
                    <x-.template.list-group>
                        <x-.template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Business Type">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    {{ $contact->business_type }}
                                </div>
                            </div>
                        </x-.template.list-item>
                        <x-.template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Tax ID">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    -
                                </div>
                            </div>
                        </x-.template.list-item>
                        <x-.template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Branch No.">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    -
                                </div>
                            </div>
                        </x-.template.list-item>
                        <x-.template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Registered Address">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    Thailand
                                </div>
                            </div>
                        </x-.template.list-item>
                        </x-template.list-group>
                </x-collapse>
                <x-collapse number="2" title="Contact Channels">
                    <x-template.list-group>
                        <x-template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Tel">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    {{ $contact->business_type }}
                                </div>
                            </div>
                        </x-template.list-item>
                        <x-template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Fax">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    {{ $contact->business_type }}
                                </div>
                            </div>
                        </x-template.list-item>
                        <x-template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Email">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    {{ $contact->business_type }}
                                </div>
                            </div>
                        </x-template.list-item>
                        <x-template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Website">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    {{ $contact->business_type }}
                                </div>
                            </div>
                        </x-template.list-item>
                        <x-template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Office address">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    {{ $contact->business_type }}
                                </div>
                            </div>
                        </x-template.list-item>
                    </x-template.list-group>
                </x-collapse>
                <x-collapse number="3" title="Account Information">
                    <x-template.list-group>
                        <x-template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Bank Account">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    {{ $contact->business_type }}
                                </div>
                            </div>
                        </x-template.list-item>
                        <x-template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Contact Credit Term">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    <x-template.list-group>
                                        <x-template.list-item class="px-0">
                                            Invoice Credit Term : Use default setting
                                        </x-template.list-item>
                                        <x-template.list-item class="px-0">
                                            Expense Credit Term : Use default setting
                                        </x-template.list-item>
                                    </x-template.list-group>
                                </div>
                            </div>
                        </x-template.list-item>
                        <x-template.list-item>
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-2">
                                    <x-template.list-item-label label="Account Record">
                                    </x-template.list-item-label>
                                </div>
                                <div class="col-8">
                                    <x-template.list-group>
                                        <x-template.list-item class="px-0">
                                            Receivable recorded as : 113101 - undefined
                                        </x-template.list-item>
                                        <x-template.list-item class="px-0">
                                            Payable recorded as : 212101 - undefined
                                        </x-template.list-item>
                                    </x-template.list-group>
                                </div>
                            </div>
                        </x-template.list-item>
                    </x-template.list-group>
                </x-collapse>
                <x-collapse number="4" title="Attach file to contact">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            Uploaded Files (You can drag and drop file)
                        </div>
                        <div class="col-12 col-md-8">
                            <button class="btn btn-primary">Add new file</button>
                        </div>
                    </div>
                </x-collapse>
            </x-tab-content>
            <x-tab-content id="overview">
                <div class="row mt-3">
                    <div class="col-12 col-md-4">
                        <h5>Total life time sales</h5>
                        <h5 class="d-inline-block">0.00</h5> THB
                    </div>
                    <div class="col-12 col-md-4">
                        <h5>Average payment days</h5>
                        <h5 class="d-inline-block">0</h5> days
                        <small class="d-block">Average 1 recent invoices or billing notes.</small>
                    </div>
                    <div class="col-12 col-md-4">
                        Credit Limit
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="47" aria-valuemin="0"
                                aria-valuemax="100" style="width: 47%">
                            </div>
                        </div>
                        <small>
                            Limit 0.00 Baht | Remaining -1,487.00 Baht
                        </small>
                    </div>
                </div>
                <x-collapse number="5" title="Income Infomation" show>
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <x-form-select label="Transaction Type" name="trx_type" :data="trxTypes()">
                                    </x-form-select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <x-form-select label="Status" name="status" :data="trxStatus()">
                                    </x-form-select>
                                </div>
                            </div>
                            <table id="transactionTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Document No.</th>
                                        <th>Issue Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Due In</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>IVT-20200800001</td>
                                        <td>21/08/2020</td>
                                        <td>28/08/2020</td>
                                        <td>1,487.00</td>
                                        <td class="text-danger">1381 days passed</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>IVT-20200800002</td>
                                        <td>21/08/2020</td>
                                        <td>28/08/2020</td>
                                        <td>1,487.00</td>
                                        <td class="text-danger">1381 days passed</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-4">
                            <h6>Revenues</h6>
                            <x-index.card>
                                <x-form-select label="Period" name="period">
                                </x-form-select>
                            </x-index.card>
                        </div>
                    </div>
                </x-collapse>
                <x-collapse number="6" title="Expense Infomation">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <x-form-select label="Transaction Type" name="trx_type" :data="trxTypes()">
                                    </x-form-select>
                                </div>
                                <div class="col-12 col-md-4">
                                    <x-form-select label="Status" name="status" :data="trxStatus()">
                                    </x-form-select>
                                </div>
                            </div>
                            <table id="transactionTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Document No.</th>
                                        <th>Issue Date</th>
                                        <th>Due Date</th>
                                        <th>Amount</th>
                                        <th>Due In</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>IVT-20200800001</td>
                                        <td>21/08/2020</td>
                                        <td>28/08/2020</td>
                                        <td>1,487.00</td>
                                        <td class="text-danger">1381 days passed</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>IVT-20200800002</td>
                                        <td>21/08/2020</td>
                                        <td>28/08/2020</td>
                                        <td>1,487.00</td>
                                        <td class="text-danger">1381 days passed</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 col-md-4">
                            <h6>Expenses</h6>
                            <x-index.card>
                                <x-form-select label="Period" name="period">
                                </x-form-select>
                            </x-index.card>
                        </div>
                    </div>
                </x-collapse>
            </x-tab-content>
            <x-tab-content id="contactPerson">
                <x-button-show-modal modal="editModal" class="mt-3">
                    <i class="fas fa-plus mr-2"></i>
                    Add Contact Person
                </x-button-show-modal>
                <div class="row mt-3">
                    <div class="col-12 col-md-6">
                        <div class="border border-success rounded px-1 py-2 mr-1">
                            <div class="d-flex justify-content-end align-items-center">
                                <x-form-switch id="1" label="On" :value="0" checked class="mr-3">
                                </x-form-switch>
                                <x-action-group label="Action">
                                    <a class="dropdown-item" href="javascript:;" id="btnEdit" data-id="">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmDelete()">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </x-action-group>
                            </div>
                            <x-template.list-group>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <x-template.list-item-label label="Name">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            SAW AUNG NAING OO
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <x-template.list-item-label label="Tel">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            0986948341
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <x-template.list-item-label label="Email">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            aungnaiu.dev@gmail.com
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <x-template.list-item-label label="Website">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            www.night.com
                                        </div>
                                    </div>
                                </x-template.list-item>
                            </x-template.list-group>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="border border-success rounded px-1 py-2 mr-1">
                            <div class="d-flex justify-content-end align-items-center">
                                <x-form-switch id="2" label="On" :value="0" checked class="mr-3">
                                </x-form-switch>
                                <x-action-group label="Action">
                                    <a class="dropdown-item" href="javascript:;" id="btnEdit" data-id="">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmDelete()">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </x-action-group>
                            </div>
                            <x-template.list-group>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <x-template.list-item-label label="Name">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            SAW AUNG NAING OO
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <x-template.list-item-label label="Tel">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            0986948341
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <x-template.list-item-label label="Email">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            aungnaiu.dev@gmail.com
                                        </div>
                                    </div>
                                </x-template.list-item>
                                <x-template.list-item>
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <x-template.list-item-label label="Website">
                                            </x-template.list-item-label>
                                        </div>
                                        <div class="col-8 col-md-10">
                                            www.night.com
                                        </div>
                                    </div>
                                </x-template.list-item>
                            </x-template.list-group>
                        </div>
                    </div>
                </div>
            </x-tab-content>
        </x-form-tabs>
    </x-form-card>

    <x-modal name="editModal" size="modal-lg">
        <div class="border-bottom border-success pb-2">
            @include('components.radio', [
                'name' => 'item_class',
                'data' => [
                    [
                        'label' => 'product.basic',
                        'value' => 'basic',
                        'checked' => 'checked',
                    ],
                    [
                        'label' => 'product.advance',
                        'value' => 'advance',
                        'checked' => '',
                    ],
                ],
            ])
        </div>
        <x-collapse number="7" title="General Informations" show>
            <div class="row">
                <div class="col-12 col-md-2">
                    <x-form-select label="contact.prefix" name="prefix" class="select2" required
                        :data="prefix()"></x-form-select>
                </div>
                <div class="col-12 col-md-3">
                    <x-form-group label="contact.other_prefix" name="other_prefix" property="readonly">
                    </x-form-group>
                </div>
                <div class="col-12 col-md-3">
                    <x-form-group label="contact.first_name" name="first_name" required>
                    </x-form-group>
                </div>
                <div class="col-12 col-md-4">
                    <x-form-group label="contact.last_name" name="last_name">
                    </x-form-group>
                </div>
                <div class="col-12 col-md-4">
                    <x-form-group label="contact.nick_name" name="nick_name">
                    </x-form-group>
                </div>
                <div class="col-12 col-md-4">
                    <x-form-group label="contact.phone" name="phone" type="tel">
                    </x-form-group>
                </div>
                <div class="col-12 col-md-4">
                    <x-form-group label="contact.email" name="email" type="email">
                    </x-form-group>
                </div>
            </div>
        </x-collapse>
        <x-collapse number="8" title="Other Contact Channels" show>
            <div class="row">
                <div class="col-12 col-md-4">
                    <x-form-select label="contact.social" name="social" class="select2" required
                        :data="socials()"></x-form-select>
                </div>
                <div class="col-12 col-md-8">
                    <x-form-group label="contact.url" name="url" type="text">
                    </x-form-group>
                </div>
            </div>
        </x-collapse>
        <x-collapse number="9" title="Position Infomation" class="border-0" show>
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-form-select label="contact.department" name="department" class="select2" required
                        :data="departments()"></x-form-select>
                </div>
                <div class="col-12 col-md-6">
                    <x-form-group label="contact.position" name="position" type="text">
                    </x-form-group>
                </div>
            </div>
        </x-collapse>
    </x-modal>

@endsection

@push('js')
@endpush

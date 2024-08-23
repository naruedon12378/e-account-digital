@extends('adminlte::page')
@php($pagename = 'ผู้ติดต่อ')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    <x-form-card>
        <x-form name="frmContact" :action="route('contacts.store')" enctype>

            <div class="border-bottom border-success p-3">
                @include('components.form-head', [
                    'label' => 'Reference',
                    'name' => 'code',
                    'value' => 'CU00001',
                    'class' => 'basic',
                ])
            </div>

            {{-- ข้อมูลกิจการ --}}
            <x-collapse number="1" title="ข้อมูลกิจการ" show>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label pr-3">เลขทะเบียน 13 หลัก</label>
                        @include('components.radio', [
                            'name' => 'region',
                            'data' => [
                                ['label' => 'ไทย', 'value' => 'local', 'checked' => 'checked'],
                                ['label' => 'ประเทศอื่น ๆ', 'value' => 'oversea', 'checked' => ''],
                            ],
                        ])
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="form-control" max="13" name="registration_number" id="registration_number" />
                    </div>
                    <div class="col-12 col-md-6">
                        <button class="btn {{ env('BTN_OUTLINE_THEME') }} d-inline-block">
                            <i class="fas fa-search mr-1"></i>
                            ค้นหา
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 col-md-4">
                        @include('components.radio', [
                            'name' => 'region',
                            'data' => [
                                ['label' => 'สำนักงานใหญ่', 'value' => 'headoffice', 'checked' => ''],
                                ['label' => 'สาขา', 'value' => 'branch', 'checked' => 'checked'],
                                ['label' => 'ไม่ระบุ', 'value' => 'nospicy', 'checked' => ''],
                            ],
                        ])
                    </div>
                    <div class="col-12 col-md-4">
                        <input type="text" class="form-control" name="branch">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label class="form-label pr-3">ชื่อกิจการ</label>
                        @include('components.radio', [
                            'name' => 'business_type',
                            'data' => [
                                ['label' => 'นิติบุคคล', 'value' => 'corporate', 'checked' => 'checked'],
                                ['label' => 'บุคคลธรรมดา', 'value' => 'personal', 'checked' => ''],
                            ],
                        ])
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4">
                        <x-form-select label="contact.sub_business_type_id" name="sub_business_type_id" class="select2"
                            required :value="$contact->sub_business_type_id" :data="businsessType()['corporate']"></x-form-select>
                    </div>
                    <div class="col-12 col-md-8">
                        <x-form-group label="contact.company_name" name="company_name" required :value="$contact->company_name">
                        </x-form-group>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-3">
                        <x-form-select label="contact.sub_business_type_id" name="sub_business_type_id" class="select2"
                            required :value="$contact->sub_business_type_id" :data="businsessType()['personal']"></x-form-select>
                    </div>
                    <div class="col-12 col-md-2">
                        <x-form-select label="contact.prefix" name="prefix" class="select2" required :value="$contact->prefix"
                            :data="prefix()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-3">
                        <x-form-group label="contact.first_name" name="first_name" required :value="$contact->first_name">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-4">
                        <x-form-group label="contact.last_name" name="last_name" required :value="$contact->last_name">
                        </x-form-group>
                    </div>
                </div>
            </x-collapse>

            {{-- ที่อยู่จดทะเบียน --}}
            <x-collapse number="2" title="ที่อยู่จดทะเบียน">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.contact_name" name="contact_name" required :value="$contact->registration?->contact_name">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-textarea label="product.address" name="address" :value="$contact->registration?->address"></x-textarea>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.district" name="district" :value="$contact->registration?->district_id">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.amphure" name="amphure" :value="$contact->registration?->amphure_id">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.province" name="province" :value="$contact->registration?->province_id">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.postcode" name="postcode" :value="$contact->registration?->postcode">
                        </x-form-group>
                    </div>
                </div>
            </x-collapse>

            {{-- ที่อยู่จัดส่งเอกสาร --}}
            <x-collapse number="3" title="ที่อยู่จัดส่งเอกสาร">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.contact_name" name="contact_name" required :value="$contact->registration?->contact_name">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-textarea label="product.address" name="address" :value="$contact->registration?->address"></x-textarea>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.district" name="district" :value="$contact->registration?->district_id">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.amphure" name="amphure" :value="$contact->registration?->amphure_id">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.province" name="province" :value="$contact->registration?->province_id">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.postcode" name="postcode" :value="$contact->registration?->postcode">
                        </x-form-group>
                    </div>
                </div>
            </x-collapse>

            {{-- ช่องทางติดต่อ --}}
            <x-collapse number="4" title="ช่องทางติดต่อ">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.email" name="email" type="email" :value="$contact->email">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.phone" name="phone" type="tel" :value="$contact->phone">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.website" name="website" :value="$contact->website">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.fax" name="fax" :value="$contact->fax">
                        </x-form-group>
                    </div>
                </div>
            </x-collapse>

            {{-- ข้อมูลบุคคลที่ติดต่อได้ --}}
            <x-collapse number="5" title="ข้อมูลบุคคลที่ติดต่อได้">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-select label="contact.prefix" name="prefix" class="select2" required :value="$contact->person?->prefix"
                            :data="prefix()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.first_name" name="first_name" :value="$contact->person?->first_name">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.last_name" name="last_name" :value="$contact->person?->last_name">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.nick_name" name="nick_name" :value="$contact->person?->nick_name">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.email" name="email" type="email" :value="$contact->person?->email">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.phone" name="phone" type="tel" :value="$contact->person?->phone">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.position" name="position" :value="$contact->person?->position">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.fax" name="fax" :value="$contact->person?->fax">
                        </x-form-group>
                    </div>
                </div>
            </x-collapse>

            {{-- ข้อมูลธนาคารของคู่ค้า --}}
            <x-collapse number="6" title="ข้อมูลธนาคารของคู่ค้า">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-select label="contact.ธนาคาร" name="bank_id" class="select2" required :value="$contact->bank_id"
                            :data="bankList()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.account_name" name="account_name" :value="$contact->bank?->account_name">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.account_number" name="account_number" :value="$contact->bank?->account_number">
                        </x-form-group>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.branch" name="branch" :value="$contact->bank?->branch">
                        </x-form-group>
                    </div>
                </div>
            </x-collapse>

            {{-- ตั้งค่าครบกำหนดชำระ --}}
            <x-collapse number="7" title="ตั้งค่าครบกำหนดชำระ">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-select label="contact.ครบกำหนดชำระใบแจ้งหนี้" name="sale_credit_term_id" class="select2"
                            required :value="$contact->sale_credit_term_id" :data="creditTerms()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-select label="contact.ครบกำหนดบันทึกรายจ่าย" name="purchase_credit_term_id"
                            class="select2" required :value="$contact->purchase_credit_term_id" :data="creditTerms()"></x-form-select>
                    </div>
                </div>
            </x-collapse>

            {{-- ตั้งค่าการบันทึกบัญชี --}}
            <x-collapse number="8" title="ตั้งค่าการบันทึกบัญชี">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-select label="contact.ครบกำหนดชำระใบแจ้งหนี้" name="sale_account_id" class="select2"
                            required :value="$contact->sale_account_id" :data="getAccountCodes(['11'])"></x-form-select>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-select label="contact.ครบกำหนดบันทึกรายจ่าย" name="credit_limit_type" class="select2"
                            required :value="$contact->purchase_account_id" :data="getAccountCodes(['21'])"></x-form-select>
                    </div>
                </div>
            </x-collapse>

            {{-- ตั้งค่าวงเงินขายเชื่อ --}}
            <x-collapse number="9" title="ตั้งค่าวงเงินขายเชื่อ">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <x-form-select label="contact.กำหนดวงเงิน" name="credit_limit_type" class="select2" required
                            :value="$contact->credit_limit_type" :data="creditLimit()"></x-form-select>
                    </div>
                    <div class="col-12 col-md-6">
                        <x-form-group label="contact.credit_limit_amt" name="credit_limit_amt" type="number"
                            :value="$contact->credit_limit_amt">
                        </x-form-group>
                    </div>
                </div>
            </x-collapse>

            <div class="text-center mt-5">
                <x-button-cancel url="{{ route('contacts.index') }}">
                    {{ __('file.Back') }}
                </x-button-cancel>
                <x-button>{{ __('file.Submit') }}</x-button>
            </div>
        </x-form>
    </x-form-card>
@endsection
@push('js')
    <script>
        $(document).on('click', '#btnSubmit', function() {
            let formData = new FormData($('#frmProduct')[0]);
            $.ajax({
                type: "POST",
                url: "{{ route('contacts.store') }}",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    window.location.href = data;
                },
                error: function(message) {
                    $('.invalid').html('');
                    for (const key in message.responseJSON.errors) {
                        if (key.includes('.')) {
                            let val = key.replace(key.slice(-2), '');
                            $('.invalid.' + val).html(message.responseJSON, errors[key]);
                        } else {
                            $('.invalid.' + key).html(message.responseJSON.errors[key]);
                        }
                    }
                }
            });
        });
        $("input[name='check_type_contact']").on('change', function() {
            console.log(this.id, this.checked)
            if (this.id == 'check_type_contact2' && this.checked) {
                $('#contact_type_2').removeAttr('hidden');
            } else {
                $('#contact_type_2').attr('hidden', true);
            }
        });

        $("input[name='type_company_id']").on('change', function() {
            console.log(this.id, this.checked)
            if (this.id == 'check_type_id_company2' && this.checked) {
                $('#company_id_type_2').removeAttr('hidden');
                $('#company_id_type_1').attr('hidden', true);
            } else {
                $('#company_id_type_1').removeAttr('hidden');
                $('#company_id_type_2').attr('hidden', true);
            }
        });

        $("input[name='branch_type']").on('change', function() {
            console.log(this.id, this.checked)
            if (this.id == 'branch_type_2' && this.checked) {
                $('#branch_type_type_2').removeAttr('hidden');
            } else {
                $('#branch_type_type_2').attr('hidden', true);
            }
        });

        $("input[name='type_registration']").on('change', function() {
            console.log(this.id, this.checked)
            if (this.id == 'type_registration_id_2' && this.checked) {
                $('#type_business2').removeAttr('hidden');
                $('#type_business1').attr('hidden', true);

            } else {
                $('#type_business1').removeAttr('hidden');
                $('#type_business2').attr('hidden', true);
            }
        });

        function taxInfo() {
            tax_id = $('#registration_number').val().replace(/[-_]/g, "").trim();
            alert(tax_id);
            if (tax_id.length === 0 || tax_id.length !== 13) {} else {
                alert("Tax ID: " + tax_id);
                $.ajax({
                    type: "get",
                    url: "https://dataapi.moc.go.th/juristic?juristic_id=" + tax_id,
                    success: function(response) {
                        alert(response);
                        console.log(response);
                        company_name = response.juristicNameTH.replace(/ จำกัด \(มหาชน\)| จำกัด/, "");
                        juristicType = response.juristicType;

                        $('#company_name').val(company_name);

                        $("#category_id2 option").each(function() {
                            var optionValue = $(this).text();
                            if (optionValue === juristicType) {
                                $(this).prop("selected", true);
                            }
                        });

                        villageName = (response.addressDetail.villageName ? response.addressDetail.villageName +
                            ' ' : '');
                        houseNumber = (response.addressDetail.houseNumber ? response.addressDetail.houseNumber +
                            ' ' : '');
                        buildingName = (response.addressDetail.buildingName ? response.addressDetail
                            .buildingName + ' ' : '');
                        addressName = (response.addressDetail.addressName ? response.addressDetail.addressName +
                            ' ' : '');
                        roomNo = (response.addressDetail.roomNo ? 'ห้องที่ ' + response.addressDetail.roomNo +
                            ' ' : '');
                        floor = (response.addressDetail.floor ? 'ชั้นที่ ' + response.addressDetail.floor +
                            ' ' : '');
                        moo = (response.addressDetail.moo ? 'หมู่ ' + response.addressDetail.moo + ' ' : '');
                        street = (response.addressDetail.street ? 'ถ. ' + response.addressDetail.street + ' ' :
                            '');
                        soi = (response.addressDetail.soi ? 'ซ. ' + response.addressDetail.soi + ' ' : '');

                        province = response.addressDetail.province;
                        district = response.addressDetail.district;
                        subDistrict = response.addressDetail.subDistrict;

                        address = villageName + houseNumber + buildingName + roomNo + addressName + floor +
                            moo + street + soi;

                        $('#address').val(address);
                        $('#sub_district').val(subDistrict);
                        $('#district').val(district);
                        $('#province').val(province);
                    }
                });
            }
        }
    </script>
@endpush

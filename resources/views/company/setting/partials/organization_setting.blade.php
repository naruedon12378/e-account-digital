<div class="card shadow-custom">
    <div class="card-header" style="border-bottom: none;">
        <button type="button" class="btn btn-tool float-right mt-1" data-card-widget="collapse">
            {{ __('payroll_setting.show_less') }}
        </button>
        <blockquote class="quote-success text-md" style="margin: 0 !important;">
            {{ __('payroll_setting.general_detail') }}
        </blockquote>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.tax_id') }}</label>
                    <input type="text" id="tax_number" name="tax_number" class="form-control"
                        value="{{ @$data->tax_number }}">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="icheck-primary icheck-inline mb-3">
                    <input type="radio" name="branch" value="0" id="head_office_chkbox"
                        {{ $data->branch == 0 ? 'checked' : '' }} />
                    <label for="head_office_chkbox">{{ __('payroll_setting.head_office') }}</label>
                </div>
                <div class="icheck-primary icheck-inline mb-3">
                    <input type="radio" name="branch" value="1" id="branch_no_chkbox"
                        {{ $data->branch == 1 ? 'checked' : '' }} />
                    <label for="branch_no_chkbox">{{ __('payroll_setting.branch') }}</label>
                </div>
            </div>
            <div class="col-sm-6 mb-3 branch-section">
                <label for="">{{ __('payroll_setting.branch_name') }}</label>
                <input type="text" name="branch_name" id="branch_name" value="{{ @$data->branch_name }}"
                    class="form-control">
            </div>
            <div class="col-sm-6 mb-3 branch-section">
                <label for="">{{ __('payroll_setting.branch_no') }}</label>
                <input type="text" name="branch_no" id="branch_no" value="{{ @$data->branch_no }}"
                    class="form-control">
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.organization_from') }}</label>
                    <select name="category_business_id" id="category_business_id" class="form-control select2"
                        style="width: 100%;">
                        @foreach ($category_businesses as $item)
                            <option value="{{ $item->id }}"
                                {{ $data->category_business_id == $item->id ? 'selected' : '' }}>
                                {{ $item->$name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.organization_type') }}</label>
                    <select name="type_business_id" id="type_business_id" class="form-control select2"
                        style="width: 100%;">
                        @foreach ($type_businesses as $item)
                            <option value="{{ $item->id }}"
                                {{ $data->type_business_id == $item->id ? 'selected' : '' }}>{{ $item->$name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.organization_name_th') }}</label>
                    <input type="text" id="name_th" name="name_th" class="form-control"
                        value="{{ @$data->name_th }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.organization_name_en') }}</label>
                    <input type="text" id="name_en" name="name_en" class="form-control"
                        value="{{ @$data->name_en }}">
                </div>
            </div>
            <div class="col-sm-12">
                <hr />
            </div>
            <div class="col-sm-12 mb-3">
                <blockquote class="quote-success text-md" style="margin: 0 !important;">
                    {{ __('payroll_setting.contact_info') }}
                </blockquote>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.email') }}</label>
                    <input type="text" class="form-control" id="email" name="email"
                        value="{{ @$data->email }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.mobile_number') }}</label>
                    <input type="text" class="form-control inputmask-phone" id="phone" name="phone"
                        value="{{ @$data->phone }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.fax') }}</label>
                    <input type="text" class="form-control" id="fax_number" name="fax_number"
                        value="{{ @$data->fax_number }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.website') }}</label>
                    <input type="text" class="form-control" id="website" name="website"
                        value="{{ @$data->website }}">
                </div>
            </div>

            <div class="col-sm-12 mb-3">
                <blockquote class="quote-success text-md" style="margin: 0 !important;">
                    {{ __('payroll_setting.registered_address_th') }}
                </blockquote>
            </div>
            <div class="col-sm-12">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.address') }}</label>
                    <textarea class="form-control" rows="3" id="detail_th" name="detail_th">{{ $data->company_address->detail_th }}</textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.sub_district') }}</label>
                    <input type="text" class="form-control" id="sub_district_th" name="sub_district_th"
                        value="{{ @$data->company_address->sub_district_th }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.district') }}</label>
                    <input type="text" class="form-control" id="district_th" name="district_th"
                        value="{{ @$data->company_address->district_th }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.province') }}</label>
                    <input type="text" class="form-control" id="province_th" name="province_th"
                        value="{{ @$data->company_address->province_th }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.postal_code') }}</label>
                    <input type="text" class="postcode form-control" oninput="mirror(this)" id="postcode"
                        name="postcode" value="{{ @$data->company_address->postcode }}">
                </div>
            </div>
            <div class="col-sm-12 mb-3">
                <blockquote class="quote-success text-md" style="margin: 0 !important;">
                    {{ __('payroll_setting.registered_address_en') }}
                </blockquote>
            </div>
            <div class="col-sm-12">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.address') }}</label>
                    <textarea class="form-control" rows="3" id="detail_en" name="detail_en">{{ @$data->company_address->detail_en }}</textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.sub_district') }}</label>
                    <input type="text" class="form-control" id="sub_district_en" name="sub_district_en"
                        value="{{ @$data->company_address->sub_district_en }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.district') }}</label>
                    <input type="text" class="form-control" id="district_en" name="district_en"
                        value="{{ @$data->company_address->district_en }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.province') }}</label>
                    <input type="text" class="form-control" id="province_en" name="province_en"
                        value="{{ @$data->company_address->province_en }}">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="">{{ __('payroll_setting.postal_code') }}</label>
                    <input type="text" class="postcode form-control" oninput="mirror(this)" id="postcode"
                        name="postcode" value="{{ @$data->company_address->postcode }}">
                </div>
            </div>
        </div>
    </div>
</div>

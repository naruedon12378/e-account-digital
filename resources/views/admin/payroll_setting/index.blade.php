@extends('adminlte::page')
@php
    $pagename = [
        'th' => 'ตั้งค่าจ่ายเงินเดือน',
        'en' => 'Payroll Setting',
    ];
    $locale = app()->getLocale();
    $name = 'name_' . $locale;
@endphp
@section('title', setting('title') . ' | ' . $pagename[$locale])
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-pen text-muted mr-2"></i> {{ $pagename[$locale] }}
        </div>

        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> {{ __('home.homepage') }}</a></li>
                    <li class="breadcrumb-item active">{{ $pagename[$locale] }}</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('payroll_setting.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id" value="{{ @$data->id }}">
            <div class="card {{ env('CARD_THEME') }} card-outline shadow-custom">
                <div class="card-header">
                    <span style="font-size: 20px;">{{ $pagename[$locale] }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            @include('admin.payroll_setting.partials.organization_setting')
                        </div>
                        <div class="col-sm-6">
                            @include('admin.payroll_setting.partials.logo_stamp_setting')
                            @include('admin.payroll_setting.partials.social_security_setting')
                            @include('admin.payroll_setting.partials.provident_fund_setting')
                            @include('admin.payroll_setting.partials.organization_bank_account_setting')
                            {{-- @include('admin.payroll_setting.partials.accounting_record') --}}
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button class="btn {{ env('BTN_THEME') }}" type="submit"><i
                                class="fas fa-save mr-2"></i>{{ __('home.save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])

    @push('js')
        <script>
            function mirror(element) {
                let value = element.value;
                $('.postcode').val(value)
            }

            function chkBranch(branch) {
                if (branch == 0) {
                    $('.branch-section').hide();
                    $('#branch_name').val('');
                    $('#branch_no').val('');
                } else {
                    $('.branch-section').show();
                }
            }

            function chkSecuritySocial(data) {
                if (data == 0) {
                    $('.social-security-section').hide();
                } else {
                    $('.social-security-section').show();
                }
            }

            function chkPVD(data) {
                if (data == 0) {
                    $('.pvd-section').hide();
                } else {
                    $('.pvd-section').show();
                }
            }

            function chkSocialSecurityBranch(data) {
                if (data == 1) {
                    $('#social_security_branch_id').hide();
                    $('#social_security_branch_id').val('000000');
                } else {
                    $('#social_security_branch_id').show();
                }
            }

            $('#showimg_logo').click(function() {
                $('#img_logo').trigger('click');
            });

            $('#showimg_stamp').click(function() {
                $('#img_stamp').trigger('click');
            });

            function previewImg(id) {
                const [file] = id.files
                if (file) {
                    if (id.id === "img_logo") {
                        showimg_logo.src = URL.createObjectURL(file);
                    } else if (id.id === "img_stamp") {
                        showimg_stamp.src = URL.createObjectURL(file);
                    }
                }
            }

            $(document).ready(function() {
                limitInputNumber('#employers_social_security_rate')
                limitInputNumber('#employers_maximum_amount')
                limitInputNumber('#employees_social_security_rate')
                limitInputNumber('#employees_maximum_amount')

                chkBranch({{ $data->branch }})
                $('input[name="branch"]').change(function() {
                    chkBranch(parseInt($(this).val()))
                })

                chkSecuritySocial({{ $data->social_security_status }})
                $('input[name="social_security_status"]').change(function() {
                    chkSecuritySocial(parseInt($(this).val()))
                })

                chkPVD({{ $data->pvd_status }})
                $('input[name="pvd_status"]').change(function() {
                    chkPVD(parseInt($(this).val()))
                })

                chkSocialSecurityBranch({{ $data->social_security_branch_type }})
                $('input[name="social_security_branch_type"]').change(function() {
                    chkSocialSecurityBranch(parseInt($(this).val()))
                })
            })
        </script>
    @endpush

    @include('admin.prefix.partials.create-modal')
    @include('admin.prefix.partials.edit-modal')
@endsection

@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
@endif

@push('js')
    <style>
        .sw-theme-arrows {
            border: none;
        }

        /* Loading */
        .lds-ellipsis {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-ellipsis div {
            position: absolute;
            top: 33px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: #508D69;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }

        .lds-ellipsis div:nth-child(1) {
            left: 8px;
            animation: lds-ellipsis1 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(2) {
            left: 8px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(3) {
            left: 32px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(4) {
            left: 56px;
            animation: lds-ellipsis3 0.6s infinite;
        }

        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(0);
            }
        }

        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(24px, 0);
            }
        }

        /* end loading */
    </style>
@endpush

@section('auth_header', 'สมัครสมาชิก')

@section('auth_body')
    <div class="mt-3" id="loading">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <div class="mt-3 d-none" id="form-div">
        <form action="{{ $register_url }}" method="post" class="register-form form">
            @csrf
            <div class="col-sm-12" id="accordion">
                <div class="card">
                    <a class="d-block w-100 collapsed show" data-toggle="collapse" href="#collapseOne"
                        aria-expanded="false">
                        <div class="card-header text-left text-dark">
                            ข้อมูลส่วนตัว
                        </div>
                    </a>
                    <div id="collapseOne" class="collapse show" data-parent="#accordion" style="">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input class="input" type="text" name="firstname" value="{{ old('firstname') }}"
                                        placeholder="Firstname" autofocus required>
                                </div>
                                <div class="col-sm-6">
                                    <input class="input" type="text" name="lastname" value="{{ old('lastname') }}"
                                        placeholder="Lastname" autofocus required>
                                </div>
                            </div>


                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <input class="input" type="email" name="email" value="{{ old('email') }}"
                                placeholder="{{ __('adminlte::adminlte.email') }}" autofocus required>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                            <div class="row">
                                <div class="col-sm-6">
                                    <input class="input" type="password" name="password" value="{{ old('password') }}"
                                        placeholder="{{ __('adminlte::adminlte.password') }}" autofocus required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input class="input" type="password" name="password_confirmation"
                                        placeholder="{{ __('adminlte::adminlte.retype_password') }}" autofocus required>

                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false">
                        <div class="card-header text-left text-dark">
                            ข้อมูลบริษัท
                        </div>
                    </a>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
                        <div class="card-body">
                            <input class="input inputmask-registration" type="text" id="tax_id" name="tax_id"
                                placeholder="เลขทะเบียน 13 หลัก" onchange="taxInfo()">

                            <div class="row mt-2">
                                <div class="col-sm-6 mt-4 text-left">
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" id="branch_chk_none" name="branch_check" value="1" />
                                        <label for="branch_chk_none">ไม่ระบุ</label>
                                    </div>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" id="branch_chk_head_office" name="branch_check" value="2"
                                            checked />
                                        <label for="branch_chk_head_office">สำนักงานใหญ่</label>
                                    </div>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" id="branch_chk_number" name="branch_check" value="3" />
                                        <label for="branch_chk_number">สาขา</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-2 text-left">
                                    <input class="input inputmask-branch-number" type="text" name="branch_number"
                                        id="branch_number" placeholder="รหัสสาขา" hidden>
                                </div>
                            </div>

                            <div class="row mt-3 text-left">
                                <div class="col-sm-12">
                                    <label>ข้อมูลกิจการ</label> <br />
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" id="justistic_person_chkbox" value="2"
                                            name="organization_info_chkbox" checked />
                                        <label for="justistic_person_chkbox">นิติบุคคล</label>
                                    </div>
                                    <div class="icheck-primary icheck-inline">
                                        <input type="radio" id="ordinary_person_chkbox" value="1"
                                            name="organization_info_chkbox" />
                                        <label for="ordinary_person_chkbox">บุคคลธรรมดา</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="justistic_person_form">
                                <div class="col-sm-4">
                                    <select class="input" name="juristic_person" id="juristic_person">
                                        {{-- <option value="" disabled selected>นิติบุคคล</option> --}}
                                        @foreach ($categories_business as $category)
                                            @if ($category->type_business_id == 2)
                                                <option value="{{ $category->id }}">{{ $category->name_th }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-sm-8">
                                    <input class="input" type="text" id="company_name" name="company_name"
                                        placeholder="ชื่อกิจการ">
                                </div>
                            </div>

                            <div class="row" id="ordinary_person_form" style="display: none">
                                <div class="col-sm-4">
                                    <select class="input" name="juristic_person" id="">
                                        @foreach ($categories_business as $category)
                                            @if ($category->type_business_id == 1)
                                                <option value="{{ $category->id }}">{{ $category->name_th }}</option>
                                            @endif
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <input class="input" type="text" name="first_name" placeholder="ชื่อจริง">
                                </div>
                                <div class="col-sm-4">
                                    <input class="input" type="text" name="last_name" placeholder="นามสกุล">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-12 text-right">
                    <a href="{{ route('login') }}" class="btn btn-secondary mt-3">
                        <i class="fas fa-arrow-left mr-2"></i> ย้อนกลับ
                    </a>
                    <button type="submit" class="btn mt-3 btn-success">
                        <span class="fas fa-user-plus"></span>
                        {{ __('adminlte::adminlte.register') }}
                    </button>
                </div>
            </div>

        </form>


    </div>

    <div class="row">
        <div class="col-sm-12 text-right">


        </div>
    </div>
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {

                setInterval(function() {
                    $('#loading').addClass('d-none');
                    $('#form-div').removeClass('d-none');
                }, 750);


                $('#smartwizard').smartWizard({
                    theme: 'arrows',
                    justified: true,
                    // loader: 'show',
                    selected: 0,
                    enableUrlHash: false,
                    // autoAdjustHeight: false,
                    animation: 'fade',
                    getContent: null,
                    lang: { // Language variables for button
                        next: 'ถัดไป',
                        previous: 'ย้อนกลับ'
                    },
                    anchor: {
                        enableNavigation: true, // Enable/Disable anchor navigation
                        enableNavigationAlways: false, // Activates all anchors clickable always
                        enableDoneState: true, // Add done state on visited steps
                        markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
                        unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
                        enableDoneStateNavigation: true // Enable/Disable the done state navigation
                    },
                });

            });

            function taxInfo() {
                tax_id = $('#tax_id').val().replace(/[-_]/g, "");

                if (tax_id.length == 13) {
                    $.ajax({
                        type: "get",
                        url: "https://dataapi.moc.go.th/juristic?juristic_id=" + tax_id,
                        success: function(response) {
                            company_name = response.juristicNameTH.replace(/ จำกัด \(มหาชน\)| จำกัด/, "");
                            juristicType = response.juristicType;

                            $('#company_name').val(company_name);

                            $("#juristic_person option").each(function() {
                                var optionValue = $(this).text();
                                if (optionValue === juristicType) {
                                    $(this).prop("selected", true);
                                }
                            });
                        }
                    });
                }
            }

            $("input[name='branch_check']").on('change', function() {
                if (this.id == 'branch_chk_number' && this.checked) {
                    $('#branch_number').removeAttr('hidden');
                } else {
                    $('#branch_number').attr('hidden', true);
                }
            });

            $("input[name='organization_info_chkbox']").on('change', function() {
                if (this.id == 'ordinary_person_chkbox' && this.checked) {
                    $('#justistic_person_form').css('display', 'none');
                    $('#ordinary_person_form').css('display', '');
                } else {
                    $('#justistic_person_form').css('display', '');
                    $('#ordinary_person_form').css('display', 'none');
                }
            });
        </script>
    @endpush
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop

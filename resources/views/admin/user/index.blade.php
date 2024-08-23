@extends('adminlte::page')
@php $pagename = 'จัดการผู้ใช้งาน'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-user text-muted mr-2"></i> {{ $pagename }}
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
            {{-- <div class="card-header" style="font-size: 20px;">
                {{ $pagename }}
            </div> --}}
            <div class="card-body">
                <div class="float-left mb-2">
                    <div class="group">
                        <svg class="icon" aria-hidden="true" viewBox="0 0 24 24">
                            <g>
                                <path
                                    d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z">
                                </path>
                            </g>
                        </svg>
                        <input type="search" id="custom-search-input" class="form-control  input-search"
                            placeholder="ค้นหา">
                    </div>
                </div>

                @if (Auth::user()->hasAnyPermission(['*', 'all user', 'create user']))
                    <div class="text-right">
                        <a href="" class="btn {{ env('BTN_OUTLINE_THEME') }} mb-2" data-toggle="modal"
                            data-target="#modal-create"><i class="fas fa-plus mr-2"></i> เพิ่มข้อมูล</a>
                    </div>
                @endif

                <table id="table" class="table table-hover dataTable no-footer nowrap" style="width: 100%;">
                    <thead class="bg-custom">
                        <tr>
                            <th class="text-center" style="width: 10%">{{ __('user.number') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('user.image') }}</th>
                            <th class="text-center">{{ __('user.fullname') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('user.role') }}</th>
                            <th class="text-center" style="width: 10%">{{ __('user.actions') }}</th>
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
            // $('input[name="iswColor"]').bootstrapSwitch('state', true, true);
            var sts_email;
            var sts;

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
                    ajax: "",
                    columnDefs: [{
                            className: 'text-center',
                            targets: [0, 2, 4]
                        },
                        {
                            orderable: false,
                            targets: [2, 4]
                        },
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'id'
                        },
                        // {
                        //     data: 'user_code'
                        // },
                        {
                            data: 'img',
                            orderable: false
                        },
                        {
                            data: 'fullname'
                        },
                        {
                            data: 'role'
                        },
                        // {
                        //     data: 'status'
                        // },
                        {
                            data: 'btn'
                        },
                    ],
                    "dom": 'rtip',
                });
            });

            //custom search datatable

            $('#custom-search-input').keyup(function() {
                table.search($(this).val()).draw();
            })


            $('#modal-create').on('hidden.bs.modal', function(event) {
                showimg.src = "https://placehold.co/300x300";
                $("#form")[0].reset();

                //clear select2
                $("#sites").select2("");
            })

            $('#modal-edit').on('hidden.bs.modal', function(event) {
                showimg.src = "https://placehold.co/300x300";
                $("#form")[0].reset();

                //clear select2
                $("#esites").select2("");
            })

            $('.btnReset').on('click', function(event) {
                showimg.src = "https://placehold.co/650x320";
            })

            //Preview img
            $('#showimg').click(function() {
                $('#img').trigger('click');
            });

            $('#eshowimg').click(function() {
                $('#eimg').trigger('click');
            });

            function previewImg(id) {
                const [file] = id.files
                if (file) {
                    if (id.id === "img") {
                        showimg.src = URL.createObjectURL(file);
                    } else if (id.id === 'eimg') {
                        eshowimg.src = URL.createObjectURL(file);
                    }
                }
            }

            //storeData
            function storeData(url) {
                if (checkEmail() === false) {
                    return false;
                }

                // if (checkUsername() === false) {
                //     return false;
                // }

                url = "{{ route('user.store') }}";

                formdata = new FormData();
                formdata.append('_token', '{{ csrf_token() }}');
                formdata.append('firstname', $('#firstname').val());
                formdata.append('lastname', $('#lastname').val());
                formdata.append('phone', $('#phone').val());
                formdata.append('line_id', $('#line_id').val());

                formdata.append('email', $('#email').val());
                formdata.append('password', $('#password').val());

                formdata.append('company', $('#company').val());
                formdata.append('sites', $('#sites').val());
                formdata.append('role', $('#role').val());

                formdata.append('img', $('#img')[0].files[0]);

                submitData(url, formdata);
            }

            //requestData
            function requestData(response) {
                $('#eid').val(response.user.id);
                $('#ename').val(response.user.name);

                $('#efirstname').val(response.user.firstname);
                $('#elastname').val(response.user.lastname);
                $('#ephone').val(response.user.phone);

                $('#eemail').val(response.user.email);

                $('#erole').val(response.user.roles[0].id);

                $('#erole').select2();

                if (response.image) {
                    eshowimg.src = response.image;
                } else {
                    eshowimg.src = "https://placehold.co/300x300";
                }

                url = "{{ url('admin/user/publish') }}/" + response.user.id;

                hasPermission = {{ Auth::user()->hasAnyPermission(['*', 'user.all', 'user.destroy']) ? 'true' : 'false' }};

                btnDel = (hasPermission == true ? '<a class="btn btn-sm btn-outline-danger" onclick="changeStatus(`' + url +
            '`)"><i class="fa fa-trash" data-toggle="tooltip" title="ลบข้อมูล"></i>ลบผู้ใช้งาน</a>' : '');


                $('#btnDel').html(btnDel);

                $('#modal-edit').modal('show');
            }


            //updateData
            function updateData() {
                id = $('#eid').val();
                // url = '{{ route('user.update', ['user' => ':id']) }}';
                // url = url.replace(':id', id);
                url = '{{ route('user.update') }}';

                eformdata = new FormData();
                eformdata.append('_token', '{{ csrf_token() }}');
                eformdata.append('firstname', $('#efirstname').val());
                eformdata.append('lastname', $('#elastname').val());
                eformdata.append('phone', $('#ephone').val());
                // eformdata.append('line_id', $('#eline_id').val());

                eformdata.append('email', $('#eemail').val());
                // eformdata.append('username', $('#eusername').val());
                eformdata.append('password', $('#epassword').val());

                eformdata.append('role', $('#erole').val());

                eformdata.append('img', $('#eimg')[0].files[0]);
                eformdata.append('id', id);

                submitData(url, eformdata);
            }

            function changeStatus(url) {
                Swal.fire({
                    title: 'ต้องการลบใช่หรือไม่',
                    text: 'หากลบข้อมูล ข้อมูลจะถูกย้ายไปอยู่ที่หน้าประวัติผู้ใช้งาน',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('home.ok') }}',
                    cancelButtonText: '{{ __('home.close') }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'get',
                            url: url,
                            success: function(response) {
                                if (response.status === true) {
                                    Swal.fire({
                                        title: response.msg,
                                        icon: 'success',
                                        toast: true,
                                        position: 'top-right',
                                        timer: 2000,
                                        showCancelButton: false,
                                        showConfirmButton: false
                                    });
                                    table.ajax.reload();
                                } else {
                                    Swal.fire({
                                        title: response.msg,
                                        icon: 'error',
                                        toast: true,
                                        position: 'top-right',
                                        timer: 2000,
                                        showCancelButton: false,
                                        showConfirmButton: false
                                    });
                                }
                            }
                        });

                    }
                });
            }

            function isValidEmail(email) {
                var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                return emailPattern.test(email);
            }

            function checkEmail() {
                var emailInput = $('#email').val();

                if (!isValidEmail(emailInput)) {
                    //remove
                    $('#email').removeClass('is-valid');
                    $('#email-valid-feedback').removeClass('valid-feedback');
                    $('#email-valid-feedback').html('');

                    //add new
                    $('#email').addClass('is-invalid');
                    $('#email-valid-feedback').addClass('invalid-feedback');
                    $('#email-valid-feedback').html("{{ trans('register.email_invalid_format') }}");

                    return false;
                }

                data = {
                    _token: CSRF_TOKEN,
                    email: $('#email').val(),
                }

                $.ajax({
                    type: "post",
                    url: "{{ route('api.check.email') }}",
                    data: data,
                    success: function(response) {

                        if (response.status === true) {

                            //remove
                            $('#email').removeClass('is-invalid');
                            $('#email-valid-feedback').removeClass('invalid-feedback');
                            $('#email-valid-feedback').html('');

                            //add new
                            $('#email').addClass('is-valid');
                            $('#email-valid-feedback').addClass('valid-feedback');
                            $('#email-valid-feedback').html("{{ trans('register.email_available') }}");

                            sts_email = response.status;

                        } else {
                            //remove
                            $('#email').removeClass('is-valid');
                            $('#email-valid-feedback').removeClass('valid-feedback');
                            $('#email-valid-feedback').html('');

                            //add new
                            $('#email').addClass('is-invalid');
                            $('#email-valid-feedback').addClass('invalid-feedback');
                            $('#email-valid-feedback').html("{{ trans('register.email_already_taken') }}");

                            sts_email = response.status;

                        }
                    }
                });

                return sts_email;
            }

            // function checkUsername() {

            //     if ($('#username').val().length < 3) {
            //         //remove
            //         $('#username').removeClass('is-valid');
            //         $('#username-valid-feedback').removeClass('valid-feedback');
            //         $('#username-valid-feedback').html('');

            //         //add new
            //         $('#username').addClass('is-invalid');
            //         $('#username-valid-feedback').addClass('invalid-feedback');
            //         $('#username-valid-feedback').html("{{ trans('register.username_length') }}");

            //         return false;
            //     }

            //     data = {
            //         _token: CSRF_TOKEN,
            //         username: $('#username').val(),
            //     }

            //     $.ajax({
            //         type: "post",
            //         url: "{{ route('api.check.username') }}",
            //         data: data,
            //         success: function(response) {

            //             if (response.status === true) {

            //                 //remove
            //                 $('#username').removeClass('is-invalid');
            //                 $('#username-valid-feedback').removeClass('invalid-feedback');
            //                 $('#username-valid-feedback').html('');

            //                 //add new
            //                 $('#username').addClass('is-valid');
            //                 $('#username-valid-feedback').addClass('valid-feedback');
            //                 $('#username-valid-feedback').html("{{ trans('register.username_available') }}");

            //                 sts = response.status;
            //             } else if (response.status === false) {
            //                 //remove
            //                 $('#username').removeClass('is-valid');
            //                 $('#username-valid-feedback').removeClass('valid-feedback');
            //                 $('#username-valid-feedback').html('');

            //                 //add new
            //                 $('#username').addClass('is-invalid');
            //                 $('#username-valid-feedback').addClass('invalid-feedback');
            //                 $('#username-valid-feedback').html("{{ trans('register.username_already_taken') }}");

            //                 sts = response.status;
            //             }
            //         }
            //     });

            //     return sts;
            // }
        </script>
    @endpush

    @include('admin.user.partials.create-modal')
    @include('admin.user.partials.edit-modal')
@endsection

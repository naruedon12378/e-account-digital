@extends('adminlte::page')
@php
    $pagename = 'ตั้งค่า';
    $locale = app()->getLocale();
    $name = 'name_' . $locale;
@endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-pen text-muted mr-2"></i> {{ $pagename }}
        </div>

        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ url('admin') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('company.update', ['company' => $company_id]) }}" method="post"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card {{ env('CARD_THEME') }} card-outline shadow-custom">
                <div class="card-header">
                    <span style="font-size: 20px;">{{ $pagename }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" name="id" id="id" value="{{ @$data->id }}">
                        <div class="col-sm-6">
                            @include('company.setting.partials.organization_setting')
                        </div>
                        <div class="col-sm-6">
                            @include('company.setting.partials.logo_stamp_setting')
                            @include('company.setting.partials.vat_setting')
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
                chkBranch({{ $data->branch }})
                $('input[name="branch"]').change(function() {
                    chkBranch(parseInt($(this).val()))
                })

            })
        </script>
    @endpush
@endsection

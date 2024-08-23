@extends('adminlte::page')
@php $pagename = 'เพิ่มบทความ'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="contrainer p-2">
        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background-color: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="{{ env('TEXT_THEME') }}"><i
                                class="fa fa-home fa-fw" aria-hidden="true"></i> หน้าแรก</a></li>
                    <li class="breadcrumb-item"><a href="#" onclick="history.back()"
                            class="{{ env('TEXT_THEME') }}">จัดการบทความ</a></li>
                    <li class="breadcrumb-item active">{{ $pagename }}</li>
                </ol>
            </nav>
        </div>

        <form method="post" action="{{ route('article.store') }}" enctype="multipart/form-data" id="form">
            @csrf
            <div class="card {{ env('CARD_THEME') }} card-outline shadow-custom">
                <div class="card-header" style="font-size: 20px;">
                    {{ $pagename }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card {{ env('CARD_THEME') }} card-outline shadow-custom">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs pull-right" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ env('TEXT_THEME') }} active" id="th-tab"
                                                data-toggle="tab" href="#th" role="tab" aria-controls="th"
                                                aria-selected="true">{{ __('article.thai') }}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ env('TEXT_THEME') }}" id="en-tab" data-toggle="tab"
                                                href="#en" role="tab" aria-controls="en"
                                                aria-selected="false">{{ __('article.english') }}</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="th" role="tabpanel"
                                            aria-labelledby="th-tab">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('article.title_th') }}</label>
                                                        <input type="text" class="form-control " name="name_th"
                                                            id="name_th">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label">{{ __('article.short_description_th') }}</label>
                                                        <br />
                                                        <textarea name="sub_detail_th" class="form-control "></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label">{{ __('article.description_th') }}</label>
                                                        <br />
                                                        <textarea class="ckEditor-th" name="detail_th" id="detail_th"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">{{ __('article.title_en') }}</label>
                                                        <input type="text" class="form-control " name="name_en"
                                                            id="name_en">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label">{{ __('article.short_description_en') }}</label>
                                                        <br />
                                                        <textarea name="sub_detail_en" id="sub_detail_en" class="form-control "></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label
                                                            class="form-label">{{ __('article.description_en') }}</label>
                                                        <br />
                                                        <textarea class="ckEditor-en" name="detail_en" id="detail_en"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">{{ __('article.images') }}</label> <small
                                    class="text-danger">{{ __('article.recommended_size') }}</small>
                                <div class="dropzone image-preview" id="imageDropzone">
                                    <div class="dz-message">
                                        <i class="fas fa-upload"></i><br>
                                        <span>{{ __('article.image_upload') }}</span>
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
@section('plugins.Sweetalert2', true)
@include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11'])
@push('js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script> --}}
    <script>
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

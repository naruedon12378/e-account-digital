@extends('adminlte::page')
@php $pagename = 'จัดการเว็บไซต์'; @endphp
@section('title', setting('title') . ' | ' . $pagename)
@section('content')
    <div class="pt-3">
        <div class="col-sm-12 ml-1 text-bold mb-1" style="font-size: 20px;">
            <i class="far fa-globe text-muted mr-2"></i> {{ $pagename }}
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
        <form action="{{ route('setting.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="card {{ env('CARD_THEME') }} card-outline shadow-custom">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs pull-right" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link {{ env('TEXT_THEME') }} active" id="general-tab" data-toggle="tab"
                                        href="#general" role="tab" aria-controls="general"
                                        aria-selected="true">ข้อมูลทั่วไป</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ env('TEXT_THEME') }}" id="images-tab" data-toggle="tab"
                                        href="#images" role="tab" aria-controls="images"
                                        aria-selected="false">รูปภาพ</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="general" role="tabpanel"
                                    aria-labelledby="general-tab">
                                    @include('admin.setting.partials.edit_general')
                                </div>
                                <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                    @include('admin.setting.partials.edit_images')
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
                </div>
            </div>
        </form>
    </div>

    @include('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'])
@section('plugins.Sweetalert2', true)

@push('js')
    <script>
        $('#showimg_favicon').click(function() {
            $('#img_favicon').trigger('click');
        });

        $('#showimg_logo').click(function() {
            $('#img_logo').trigger('click');
        });

        $('#showimg_og').click(function() {
            $('#img_og').trigger('click');
        });

        $('#showimg_aboutus').click(function() {
            $('#img_aboutus').trigger('click');
        });

        $('#showimg_product').click(function() {
            $('#img_product').trigger('click');
        });

        $('#showimg_service').click(function() {
            $('#img_service').trigger('click');
        });

        $('#showimg_promotion').click(function() {
            $('#img_promotion').trigger('click');
        });

        $('#showimg_news').click(function() {
            $('#img_news').trigger('click');
        });

        $('#showimg_review').click(function() {
            $('#img_review').trigger('click');
        });

        $('#showimg_member').click(function() {
            $('#img_member').trigger('click');
        });

        $('#showimg_faq').click(function() {
            $('#img_faq').trigger('click');
        });

        $('#showimg_contact').click(function() {
            $('#img_contact').trigger('click');
        });

        function previewImg(id) {
            const [file] = id.files
            if (file) {
                if (id.id === "img_favicon") {
                    showimg_favicon.src = URL.createObjectURL(file);
                } else if (id.id === "img_logo") {
                    showimg_logo.src = URL.createObjectURL(file);
                } else if (id.id === "img_og") {
                    showimg_og.src = URL.createObjectURL(file);
                } else if (id.id === "img_aboutus") {
                    showimg_aboutus.src = URL.createObjectURL(file);
                } else if (id.id === "img_product") {
                    showimg_product.src = URL.createObjectURL(file);
                } else if (id.id === "img_service") {
                    showimg_service.src = URL.createObjectURL(file);
                } else if (id.id === "img_promotion") {
                    showimg_promotion.src = URL.createObjectURL(file);
                } else if (id.id === "img_news") {
                    showimg_news.src = URL.createObjectURL(file);
                } else if (id.id === "img_review") {
                    showimg_review.src = URL.createObjectURL(file);
                } else if (id.id === "img_member") {
                    showimg_member.src = URL.createObjectURL(file);
                } else if (id.id === "img_faq") {
                    showimg_faq.src = URL.createObjectURL(file);
                } else if (id.id === "img_contact") {
                    showimg_contact.src = URL.createObjectURL(file);
                }
            }
        }
    </script>
@endpush
@endsection

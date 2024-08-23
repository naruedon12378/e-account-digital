<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title', setting('title'))
    </title>

    {{-- <script src="https://kit.fontawesome.com/4134f7c670.js" crossorigin="anonymous"></script> --}}
    <link href='https://fonts.googleapis.com/css?family=Kanit:400,300&subset=thai,latin' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.4.6/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('loadingbar/loading-bar.css') }}">
    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Pace --}}
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">

    {{-- Base Stylesheets --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

        @if (config('adminlte.google_fonts.allowed', true))
            <link rel="stylesheet"
                href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @endif
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

    {{-- Livewire Styles --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

    {{-- Favicon --}}
    @if (config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        {{-- Custom Favicon --}}
        <link rel="shortcut icon"
            href="@if (setting('img_favicon')) {{ asset(setting('img_favicon')) }} @else {{ asset('images/no-image.jpg') }} @endif" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif

    <link href="{{ asset('plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/summernote/plugin/tam-emoji/css/emoji.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/custom.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap-select.min.css') }}"> --}}

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap-datepicker.min.css') }}">
</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')
    @include('vendor.adminlte.partials.common.notification')

    {{-- Base Scripts --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        {{-- <script src="{{ asset('vendor/bootstrap/js/bootstrap-select.min.js') }}"></script> --}}
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        {{-- JQuery Validation --}}
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
        {{-- Configured Scripts --}}
        @include('adminlte::plugins', ['type' => 'js'])

        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Livewire Script --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- SummerNote --}}
    <script src="{{ asset('plugins/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('plugins/summernote/plugin/tam-emoji/js/config.js') }}" rel="stylesheet"></script>
    <script src="{{ asset('plugins/summernote/plugin/tam-emoji/js/tam-emoji.min.js') }}" rel="stylesheet"></script>

    {{-- LoadingBar --}}
    <script type="text/javascript" src="{{ asset('loadingbar/loading-bar.js') }}"></script>

    {{-- datetime picker --}}
    <script src="{{ asset('vendor/jquery/bootstrap-datepicker.min.js') }}"></script>
    {{-- datatable --}}
    <script>
        var table;
        function dataTable(columns = []) {
            table = $('#table').DataTable({
                pageLength: 10,
                responsive: true,
                fixedHeader: {
                    header: true,
                    footer: true
                },
                processing: false,
                // scrollX: true,
                scrollCollapse: true,
                serverSide: true,
                ajax: "",
                columns,
                searchDelay: 500,
                order: [
                    [1, 'desc']
                ],
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                },
                {
                    orderable: false,
                    targets: [0, columns.length -1]
                }],
                fixedColumns: {
                    start: 1
                },
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
            });
        }
    </script>

    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        // # Emoji Button
        document.emojiButton = 'fas fa-smile'; // default: fa fa-smile-o
        // #The Emoji selector to input Unicode characters instead of images
        document.emojiType = 'unicode'; // default: image
        // #Relative path to emojis
        document.emojiSource = '{{ asset('plugins/summernote/plugin/tam-emoji/img') }}';

        //Lightbox for Bootstrap
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox();
        });

        //SummerNote
        $(document).ready(function() {
            // //Prevent View Source Code
            // $(document).keydown(function (event) {
            //     if (event.keyCode == 123) { // Prevent F12
            //         return false;
            //     } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
            //         return false;
            //     } else if(event.ctrlKey && event.shiftKey && event.keyCode == 74){ // Prevent Ctrl+Shift+J
            //         return false;
            //     } else if(event.ctrlKey && event.shiftKey && event.keyCode == 67){ // Prevent Ctrl+Shift+C
            //         return false;
            //     } else if(event.ctrlKey && event.keyCode == 85){ //Prevent Ctrl+U
            //         return false;
            //     } else if(event.keyCode == 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey)){ //Prevent S key + macOS
            //         return false;
            //     }
            // });

            // // Prevent Right Click
            // $(document).on("contextmenu", function (e) {
            //     e.preventDefault();
            // });

            //DualListbox
            $('.duallistbox').bootstrapDualListbox({
                infoText: 'ทั้งหมด {0} รายการ',
                infoTextEmpty: 'ไม่มีรายการ',
                filterPlaceHolder: 'ค้นหา',
                moveAllLabel: 'เลือกทั้งหมด',
                removeAllLabel: 'นำออกทั้งหมด',
                infoTextFiltered: 'ทั้งหมด {0} จาก {1} รายการ',
                filterTextClear: '',
            });

            //toastr
            toastr.options = {
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "progressBar": true,
                "newestOnTop": true,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            //Select2 Taging
            $(".select2Tag").select2({
                tags: true,
                tokenSeparators: [',', ' ']
            })

            $('.select2').select2();
            $('[data-toggle="tooltip"]').tooltip();

            //Date Picker
            $(".datepicker").Zebra_DatePicker({
                format: "d/m/Y",
                show_icon: false,
                readonly_element: false,
            });

            $(".datepicker-year").Zebra_DatePicker({
                format: 'Y',
                show_icon: false,
                readonly_element: false,
            });

            //FlatPicker
            $(".flatpicker").flatpickr({
                dateFormat: "d/m/Y",
            });

            $(".flatpicker-maxToday").flatpickr({
                dateFormat: "d/m/Y",
                maxDate: "today",
            });

            //Inputmask
            $(".inputmask-phone").inputmask("999-999-9999", {
                inputmode: "numeric"
            });

            $(".inputmask-date").inputmask("99/99/9999", {
                alias: "date",
                inputFormat: "dd/mm/yyyy",
                inputmode: "numeric"
            });

            $(".inputmask-year").inputmask("9999", {
                alias: "date",
                inputFormat: "yyyy",
                inputmode: "numeric"
            });

            $(".inputmask-registration").inputmask("9-9999-99999-999", {
                inputmode: "numeric"
            });

            $(".inputmask-branch-number").inputmask("99999", {
                inputmode: "numeric"
            });

            bsCustomFileInput.init();
            // emojione.ascii = true;

        });

        //CKEditor
        //CK th
        ClassicEditor.create(document.querySelector('.ckEditor-th'), {
                width: '800px', // กำหนดความกว้าง
                height: '400px', // กำหนดความสูง
                fontSize: {
                    options: [
                        8,
                        10,
                        12,
                        14,
                        'default',
                        18,
                        20,
                        22,
                        24,
                        26,
                    ]
                },
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}",
                },
            }).then(editor => {
                editor.editing.view.document.on('keydown', (event, data) => {
                    if (data.domEvent.key === 'Delete' || data.domEvent.key === 'Backspace') {
                        // ส่งคำขอลบรูปภาพ
                        const selection = editor.model.document.selection;
                        const selectedElement = selection.getSelectedElement();

                        if (selectedElement && selectedElement) {
                            if (selectedElement.getAttribute('src')) {
                                const imageUrl = selectedElement.getAttribute('src');
                                image = imageUrl.split('/');

                                data = new FormData();
                                data.append("image", image[5]);
                                data.append("_token", CSRF_TOKEN);
                                // ส่งคำขอลบรูปภาพ
                                $.ajax({
                                    type: "POST",
                                    data: data,
                                    url: "{{ route('ckeditor.delete') }}", // delete file
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        //nothing
                                    }
                                });
                            }
                        }
                    }
                });
            })
            .catch(error => {
                // console.error(error);
            });

        // CK en
        ClassicEditor.create(document.querySelector('.ckEditor-en'), {
                width: '800px', // กำหนดความกว้าง
                height: '400px', // กำหนดความสูง
                fontSize: {
                    options: [
                        8,
                        10,
                        12,
                        14,
                        'default',
                        18,
                        20,
                        22,
                        24,
                        26,
                    ]
                },
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}",
                },
            }).then(editor => {
                editor.editing.view.document.on('keydown', (event, data) => {
                    if (data.domEvent.key === 'Delete' || data.domEvent.key === 'Backspace') {
                        // ส่งคำขอลบรูปภาพ
                        const selection = editor.model.document.selection;
                        const selectedElement = selection.getSelectedElement();

                        if (selectedElement && selectedElement) {
                            if (selectedElement.getAttribute('src')) {
                                const imageUrl = selectedElement.getAttribute('src');
                                image = imageUrl.split('/');

                                data = new FormData();
                                data.append("image", image[5]);
                                data.append("_token", CSRF_TOKEN);
                                // ส่งคำขอลบรูปภาพ
                                $.ajax({
                                    type: "POST",
                                    data: data,
                                    url: "{{ route('ckeditor.delete') }}", // this file uploads the picture and
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        //nothing
                                    }
                                });
                            }
                        }
                    }
                });
            })
            .catch(error => {
                // console.error(error);
            });

        //CK short th
        ClassicEditor.create(document.querySelector('.ckEditor-short-th'), {
                width: '800px', // กำหนดความกว้าง
                height: '400px', // กำหนดความสูง
                fontSize: {
                    options: [
                        8,
                        10,
                        12,
                        14,
                        'default',
                        18,
                        20,
                        22,
                        24,
                        26,
                    ]
                },
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}",
                },
            }).then(editor => {
                editor.editing.view.document.on('keydown', (event, data) => {
                    if (data.domEvent.key === 'Delete' || data.domEvent.key === 'Backspace') {
                        // ส่งคำขอลบรูปภาพ
                        const selection = editor.model.document.selection;
                        const selectedElement = selection.getSelectedElement();

                        if (selectedElement && selectedElement) {
                            if (selectedElement.getAttribute('src')) {
                                const imageUrl = selectedElement.getAttribute('src');
                                image = imageUrl.split('/');

                                data = new FormData();
                                data.append("image", image[5]);
                                data.append("_token", CSRF_TOKEN);
                                // ส่งคำขอลบรูปภาพ
                                $.ajax({
                                    type: "POST",
                                    data: data,
                                    url: "{{ route('ckeditor.delete') }}", // this file uploads the picture and
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        //nothing
                                    }
                                });
                            }
                        }
                    }
                });
            })
            .catch(error => {
                // console.error(error);
            });

        //CK short en
        ClassicEditor.create(document.querySelector('.ckEditor-short-en'), {
                width: '800px', // กำหนดความกว้าง
                height: '400px', // กำหนดความสูง
                fontSize: {
                    options: [
                        8,
                        10,
                        12,
                        14,
                        'default',
                        18,
                        20,
                        22,
                        24,
                        26,
                    ]
                },
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload') . '?_token=' . csrf_token() }}",
                },
            }).then(editor => {
                editor.editing.view.document.on('keydown', (event, data) => {
                    if (data.domEvent.key === 'Delete' || data.domEvent.key === 'Backspace') {
                        // ส่งคำขอลบรูปภาพ
                        const selection = editor.model.document.selection;
                        const selectedElement = selection.getSelectedElement();

                        if (selectedElement && selectedElement) {
                            if (selectedElement.getAttribute('src')) {
                                const imageUrl = selectedElement.getAttribute('src');
                                image = imageUrl.split('/');

                                data = new FormData();
                                data.append("image", image[5]);
                                data.append("_token", CSRF_TOKEN);
                                // ส่งคำขอลบรูปภาพ
                                $.ajax({
                                    type: "POST",
                                    data: data,
                                    url: "{{ route('ckeditor.delete') }}", // this file uploads the picture and
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        //nothing
                                    }
                                });
                            }
                        }
                    }
                });
            })
            .catch(error => {
                // console.error(error);
            });

        //Dropzone

        Dropzone.prototype.defaultOptions.dictRemoveFile =
            "<i class=\"fa fa-trash ml-auto mt-2 fa-1x text-danger\"></i> ลบรูปภาพ";
        Dropzone.autoDiscover = false;
        var uploadedImageMap = {}
        $('#imageDropzone').dropzone({
            url: "{{ route('dropzone.upload') }}",
            addRemoveLinks: true,
            dictCancelUpload: 'ยกเลิกอัพโหลด',
            acceptedFiles: 'image/*',
            //alert accepted file
            "error": function(file, message, xhr) {
                if (xhr == null) this.removeFile(file); // perhaps not remove on xhr errors
                if (file.type == 'application/pdf') {
                    Swal.fire({
                        icon: 'error',
                        title: 'ผิดพลาด',
                        text: 'ไฟล์ที่นำเข้าต้องเป็นไฟล์รูปภาพเท่านั้น',
                        timer: 1500
                    })
                }
            },
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $(file.previewElement).append('<input type="hidden" name="image[]" value="' + response.name +
                    '">')
                uploadedImageMap[file.name] = response.name
            },
            init: function() {
                @if (isset($images))
                    @foreach ($images as $key => $image)
                        var file = {!! json_encode($image) !!};
                        file.url = '{!! $image->getUrl() !!}';
                        file.name = '{!! $image->file_name !!}';
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.url);
                        file.previewElement.classList.add('dz-complete')
                        $(file.previewElement).append('<input type="hidden" name="image[]" value="' + file
                            .file_name + '">')
                    @endforeach
                @endif
                this.on('removedfile', (file) => {
                    filename = JSON.parse(file.xhr.response).name;
                    let data = {
                        '_token': '{{ csrf_token() }}',
                        'name': filename,
                    }

                    $.ajax({
                        type: 'post',
                        url: "{{ route('dropzone.delete') }}",
                        data: data,
                        success: (response) => {

                        }
                    });
                });
            }
        });
        $(function() {
            $("#imageDropzone").sortable({
                items: '.dz-preview',
                cursor: 'move',
                opacity: 0.5,
                containment: '#imageDropzone',
                distance: 20,
                tolerance: 'pointer'
            });
        });
    </script>

    {{-- JS function --}}
    <script src="{{ asset('js/admin/function.js') }}"></script>

    <script>
        $.validator.setDefaults({
            errorPlacement: function(error, element) {
                $(element).attr({
                    "title": error.text()
                });
            },
            highlight: function(element) {
                // $(element).css({
                //     "border": "2px solid #dc3545"
                // });
                $(element).removeClass("is-valid");
                $(element).addClass("is-invalid");
            },
            unhighlight: function(element) {
                // $(element).css({
                //     "border": "2px solid #dc3545"
                // });
                $(element).removeClass("is-invalid");
                $(element).addClass("is-valid");
            }
        });

        function updateFileLabel() {
            let file = $(this).prop('files')[0].name;
            let nearestLabel = $(this).closest('.input-group').find('.custom-file-label');
            nearestLabel.text(file);
        }

        function limitInputNumber(inputSelector) {
            $(inputSelector).on('input', function() {
                var max = parseInt($(this).attr('max'));
                if (parseInt($(this).val()) > max) {
                    $(this).val(max); // ถ้าค่าที่ป้อนมามากกว่าค่าสูงสุดที่กำหนดไว้ ให้กำหนดค่าใหม่เป็นค่าสูงสุด
                }
            });
        }
    </script>

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>

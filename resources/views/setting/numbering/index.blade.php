@extends('adminlte::page')
@php($pagename = 'Numbering System')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    <x-form-card>
        <x-form-tabs :tabs="$tabs">
            <x-tab-content id="home" active>
                @include('setting.numbering.table', ['setting' => $series['QO']])
                @include('setting.numbering.table', ['setting' => $series['TDN']])
                @include('setting.numbering.table', ['setting' => $series['IV']])
                @include('setting.numbering.table', ['setting' => $series['IVT']])
                @include('setting.numbering.table', ['setting' => $series['DN']])
                @include('setting.numbering.table', ['setting' => $series['RE']])
                @include('setting.numbering.table', ['setting' => $series['RT']])
                @include('setting.numbering.table', ['setting' => $series['TIV']])
                @include('setting.numbering.table', ['setting' => $series['CN']])
                @include('setting.numbering.table', ['setting' => $series['CNT']])
                @include('setting.numbering.table', ['setting' => $series['BN']])
                @include('setting.numbering.table', ['setting' => $series['DBN']])
                @include('setting.numbering.table', ['setting' => $series['DBNT']])
            </x-tab-content>
            <x-tab-content id="purchase">
                @include('setting.numbering.table', ['setting' => $series['PO']])
                @include('setting.numbering.table', ['setting' => $series['POA']])
                @include('setting.numbering.table', ['setting' => $series['PR']])
                @include('setting.numbering.table', ['setting' => $series['EXP']])
                @include('setting.numbering.table', ['setting' => $series['CNX']])
                @include('setting.numbering.table', ['setting' => $series['CPN']])
                @include('setting.numbering.table', ['setting' => $series['PA']])
            </x-tab-content>
        </x-form-tabs>
    </x-form-card>
@endsection

@push('js')
    <script>
        $(document).on('click', '.jsSubmit', function() {
            let trxType = $(this).attr('data-id');
            let formData = new FormData($('#' + trxType)[0]);
            let routeName = $('#' + trxType).attr('action');
            $.ajax({
                type: "POST",
                url: routeName,
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    Swal.fire({
                        position: 'top-right',
                        icon: 'success',
                        title: data.message,
                        toast: true,
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                    $('#accordion'+trxType+' .number').text(data.number);
                },
                error: function(message) {
                    let text = '';
                    for (const key in message.responseJSON.errors) {
                        text += message.responseJSON.errors[key];
                    }
                    Swal.fire({
                        position: 'top-right',
                        icon: 'error',
                        title: text,
                        toast: true,
                        timer: 2000,
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                }
            });
        });
    </script>
@endpush

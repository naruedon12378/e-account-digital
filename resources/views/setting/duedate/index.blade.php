@extends('adminlte::page')
@php($pagename = 'Numbering System')
<x-template.pagetitle :page="$pagename"></x-template.pagetitle>

@section('content')
    <x-template.breadcrumb :page="$pagename"></x-template.breadcrumb>
    <x-form-card>
        <x-form name="frmSetting" :action="route('due_date.store')">
            <x-form-tabs :tabs="$tabs">
                <x-tab-content id="home" active>
                    @include('setting.duedate.table', ['setting' => $duedates['QO']])
                    @include('setting.duedate.table', ['setting' => $duedates['IV']])
                    @include('setting.duedate.table', ['setting' => $duedates['BN']])
                </x-tab-content>
                <x-tab-content id="purchase">
                    @include('setting.duedate.table', ['setting' => $duedates['EXP']])
                    @include('setting.duedate.table', ['setting' => $duedates['CPN']])
                    @include('setting.duedate.table', ['setting' => $duedates['PA']])
                </x-tab-content>
            </x-form-tabs>
            
            <div class="text-center mt-5">
                <x-button-cancel url="{{ route('due_date.index') }}">
                    {{ __('file.Cancel') }}
                </x-button-cancel>
                <x-button>{{ __('file.Submit') }}</x-button>
            </div>

        </x-form>
    </x-form-card>
@endsection

@push('js')
    <script>
        const dueDates = @json($duedates);
        $('input[type="number"]').keyup(function(){
            let period = $(this).val();
            if (period != '' && period >= 0) {
                let trxType = $(this).parents('tr').attr('data-id');
                let setting = dueDates[trxType];
                let dueDate = setDate(period);
                $('#due_date'+trxType).text(dueDate);
            }
        });

        function setDate(days){
            let dueDate = new Date();
            dueDate.setDate(dueDate.getDate() + parseInt(days));
            return dateFormat(dueDate);
        }

        function dateFormat(date){
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const formattedDate = `${year}-${month}-${day}`;
            return formattedDate;
        }
       
        $(document).on('click', '#btnSubmit', function() {
            let formData = new FormData($('#frmSetting')[0]);
            let routeName = $('#frmSetting').attr('action');
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

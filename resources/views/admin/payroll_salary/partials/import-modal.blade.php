<form id="form">
    <div class="modal fade" id="modal-import" data-backdrop="static" data-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Import</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <blockquote class="quote-warning text-sm" style="margin: 0 !important;">
                            <a href="{{ route('export.payroll.import.employee.xlsx') }}">Download this form (.xlsx)</a>
                            to prepare data to import
                        </blockquote>
                    </div>

                    <label>Upload File</label>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="import_doc" accept=".xlsx, .xls"
                                aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="import_doc">Choose file</label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{ __('home.cancel') }}</button>
                    <button type="reset" class="btn btn-danger">{{ __('home.reset') }}</button>
                    <a class="btn {{ env('BTN_THEME') }} btn-save">{{ __('home.save') }}</a>
                </div>
            </div>
        </div>
    </div>
</form>


@push('js')
    <script>
        $(document).ready(function() {
            $('.btn-save').on('click', function() {
                let file = $('#import_doc')[0].files[0];
                if (file) {
                    var fileName = file.name;
                    var fileExtension = fileName.split('.').pop().toLowerCase();
                    var allowedExtensions = ['xls', 'xlsx'];

                    if (allowedExtensions.indexOf(fileExtension) !== -1) {
                        var formData = new FormData();
                        formData.append('file', file);
                        $.ajax({
                            url: "{{ route('read.excel') }}",
                            type: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response) {
                                    table.clear().draw()
                                    let financialRecords = JSON.parse(
                                        '{!! $financial_records !!}');

                                    $.each(response, function(index, employee) {
                                        let empLength = employee.length;
                                        let dynamicRecords = "";
                                        $.each(financialRecords, function(key, record) {
                                            var typeAccount = 'calAdd';
                                            if (record.type_account == 1) {
                                                typeAccount = 'calCut';
                                            }
                                            var inputElement = `
                                            <td>
                                                <input name="frecord_${key}[]" style="width: 150px"
                                                    type="number" step="0.01" value="${employee[key+3]}"
                                                    class="form-control text-right numberInput ${typeAccount}">
                                            </td>
                                        `;
                                            dynamicRecords += inputElement
                                        });

                                        var sso_status = employee[empLength - 1] == 0 ?
                                            0 : 1;

                                        var sso = employee[empLength - 1] == "" ? 0 :
                                            employee[empLength - 1];
                                        var with_holding = employee[empLength - 2] ==
                                            "" ? 0 :
                                            employee[empLength - 2];

                                        var newRowHtml = `
                                                <tr>
                                                    <td>
                                                        <select name="employee[]" class="form-control select2" style="width: 250px">
                                                            <option value="${employee[0]}"
                                                                data-salary="${employee[2]}" data-social_security_status="${sso_status}" selected>${employee[1]}
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input name="salary[]" style="width: 150px" type="number" step="0.01"
                                                            value="${employee[2]}" class="form-control text-right numberInput calAdd">
                                                    </td>
                                                    ${dynamicRecords}
                                                    <td>
                                                        <input name="withholding_tax[]" style="width: 150px" type="number"
                                                            step="0.01" value="${with_holding}"
                                                            class="form-control text-right numberInput calCut">
                                                    </td>
                                                    <td>
                                                        <input name="social_security[]" style="width: 150px" type="number"
                                                            step="0.01" value="${sso}"
                                                            max="{{ $company_setting->employees_maximum_amount }}"
                                                            class="form-control text-right numberInput calCut">
                                                    </td>
                                                    <td>
                                                        <input name="total_revenue[]" style="width: 150px" type="number"
                                                            step="0.01" value="0.00"
                                                            class="form-control text-right numberInput sumAdd">
                                                    </td>
                                                    <td>
                                                        <input name="total_deduct[]" style="width: 150px" type="number"
                                                            step="0.01" value="0.00"
                                                            class="form-control text-right numberInput sumCut">
                                                    </td>
                                                    <td>
                                                        <input name="net_salary[]" style="width: 150px" type="number"
                                                            step="0.01" value="0.00"
                                                            class="form-control text-right numberInput calTotal">
                                                    </td>
                                                    <td><a class="btn btn-danger removeitem"><i class="fas fa-trash-alt"></i></a></td>
                                                </tr>
                                            `;
                                        var newRow = table.row.add($(newRowHtml)).draw(
                                                false)
                                            .node();
                                        $(newRow).find('.select2').select2();
                                    })
                                    Swal.fire({
                                        title: 'ดำเนินการสำเร็จ',
                                        icon: 'success',
                                        toast: true,
                                        position: 'top-right',
                                        timer: 2000,
                                        showCancelButton: false,
                                        showConfirmButton: false
                                    });
                                    $('#modal-import').modal('hide')
                                }
                            },
                            error: function(xhr, status, error) {}
                        })
                    } else {
                        toastr.error('ไฟล์ไม่อนุญาต!');
                        $('.custom-file-label').text('Choose File')
                        $('#import_doc').val('');
                    }
                } else {
                    toastr.error('กรุณาเลือกไฟล์เอกสาร!');
                }
            });
        });
    </script>
@endpush

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function confirmDelete(url) {
    Swal.fire({
        title: 'ต้องการลบใช่หรือไม่',
        text: 'หากลบข้อมูล ข้อมูลอื่นๆที่เกี่ยวข้องจะถูกลบทั้งหมด',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก',
        reverseButtons: true,
        showLoaderOnConfirm: true,
        allowOutsideClick: false,
        preConfirm: () => {
            return $.ajax({
                type: 'DELETE',
                url: url,
                data: {
                    _token: CSRF_TOKEN
                },
                dataType: 'JSON',
                success: function (response) {
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
        },
    });
}

function publish(url) {
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            if (response.status === true) {
                Swal.fire({
                    position: 'top-right',
                    title: response.msg,
                    icon: 'success',
                    timer: 2000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                });
                table.ajax.reload();
            } else {
                Swal.fire({
                    position: 'top-right',
                    title: response.msg,
                    icon: 'error',
                    timer: 2000,
                    toast: true,
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }
        }
    });
}

function sort(ele, url) {
    var frmdata = {
        'data': ele.value
    };
    $.ajax({
        type: 'get',
        url: url,
        data: frmdata,
        success: function (response) {
            if (response.status === true) {
                Swal.fire({
                    position: 'top-right',
                    icon: 'success',
                    title: response.message,
                    toast: true,
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            } else {
                Swal.fire({
                    position: 'top-right',
                    icon: 'error',
                    title: response.message,
                    toast: true,
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: false
                })
            }
        }
    })
}

function editData(url) {
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            requestData(response);
        }
    });
}

function submitData(url, formdata) {
    return new Promise(function (resolve, reject) {
        Swal.fire({
            title: 'ต้องการยืนยันใช่หรือไม่ ?',
            icon: 'question',
            backdrop: true,
            padding: '1em',
            showCancelButton: true,
            reverseButtons: true,
            // confirmButtonColor: '#ffc107',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            showLoaderOnConfirm: true,
            allowOutsideClick: false, // ไม่ให้คลิกภายนอกเพื่อปิด Alert
            preConfirm: () => {
                return $.ajax({
                    type: 'post',
                    url: url,
                    traditional: true,
                    contentType: false,
                    processData: false,
                    data: formdata,
                }).then(function (response) {
                    if (response.status === true) {
                        Swal.fire({
                            title: response.msg,
                            icon: 'success',
                            timer: 2000,
                            toast: true,
                            position: 'top-right',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        table.ajax.reload();
                        resolve(response); // ส่ง Promise กลับเมื่อทุกรายการสำเร็จ
                    } else {
                        Swal.fire({
                            title: response.msg,
                            icon: 'error',
                            timer: 2000,
                            toast: true,
                            position: 'top-right',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        reject(response); // ปฏิเสธ Promise หากเจอข้อผิดพลาด
                    }
                }).catch(function (error) {
                    // จัดการเวลาเกิดข้อผิดพลาดใน AJAX request
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด',
                        icon: 'error',
                        text: 'ไม่สามารถดำเนินการได้',
                    });
                    console.error('AJAX Error:', error);
                    reject(error); // ปฏิเสธ Promise หากเกิดข้อผิดพลาดใน AJAX request
                });
            },
        });
    });
}


function fileValidation(ele) {
    var fileInput = ele;
    var filePath = fileInput.value;

    // Allowing file type
    var allowedExtensions = /(\.gif|\.png|\.jpeg|\.jpg)$/i;

    if (!allowedExtensions.exec(filePath)) {
        Swal.fire({
            icon: 'error',
            title: 'ผิดพลาด',
            text: 'ไฟล์ที่นำเข้าต้องเป็นไฟล์รูปภาพเท่านั้น',
            timer: 2000,
        })
        fileInput.value = '';
        return false;
    } else {
        previewImg(fileInput);
    }
}


// image upload
var appendClass = "";
const dt = new DataTransfer();
// upload file
$(document).on('change', '.mutipleImage', function (e) {
    appendClass = $(this).parent().parent().parent().data('name');
    var totalImage = 0;
    var htmlText = "{{ __('file.Attach Image Message') }}";

    $('.uploadBox').each(function () {
        totalImage++;
    });

    if (this.files.length + totalImage > 5) {
        Swal.fire({
            icon: 'error',
            title: '<span class="text-danger">Invalid data!</span>',
            html: htmlText,
            confirmButtonColor: '#1877f2',
        });
    } else {
        for (var i = 0; i < this.files.length; i++) {
            let imageBox = $('<div/>', {
                class: `uploadBox text-center p-2`
            }),
                fileName = $(`<button type="button" class="btn btn-link text-danger btnRemove"
                        data-id="${this.files.item(i).name}">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>`);
            imageBox.append(
                `<img src="${URL.createObjectURL(event.target.files[i])}" class="img-fluid img-thumbnail" />`
            ).append(fileName);

            $('.' + appendClass).append(imageBox);
        }

        for (let file of this.files) {
            dt.items.add(file);
        }
        this.files = dt.files;
    }
});

// remove image
$(document).on('click', '.btnRemove', function () {
    let imgName = $(this).data('id');
    appendClass = $(this).parent().parent().data('name');

    for (let i = 0; i < dt.items.length; i++) {
        if (imgName == dt.items[i].getAsFile().name) {
            dt.items.remove(i);
            continue;
        }
    }

    $('.' + appendClass + ' .mutipleImage').files = dt.files;
    $(this).parent().remove();
});

// submit form
function submitForm(routeName, formData, modalName = "") {
    $.ajax({
        type: "POST",
        url: routeName,
        data: formData,
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (data) {
            Swal.fire({
                title: data.msg ? data.msg : data,
                icon: 'success',
                timer: 2000,
                toast: true,
                position: 'top-right',
                showCancelButton: false,
                showConfirmButton: false
            });

            if (modalName !== "")
                $('#' + modalName).modal('hide');

            if (data.redirect) {
                window.location.href = data.redirect;
                return true;
            }
            if( data.table_not_reload ){
            }else{
                table.ajax.reload();
            }
            return true;
        },
        error: function (message) {
            formSubmitLoading(false);
            $('.invalid').html('');

            if( message.responseJSON ){
                if ( message.responseJSON.validation && message.responseJSON.errors) {

                    let msg_alert_str = '';
                    message.responseJSON.errors.forEach(element => {
                        msg_alert_str += element.msg + "\n";
                        $('.invalid.' + element.input_name).html(element.msg);
                        console.log('error', element);
                    });

                    if (msg_alert_str != '') {
                        Swal.fire({
                            title: msg_alert_str,
                            icon: 'error',
                            timer: 3000,
                            toast: true,
                            position: 'top-right',
                            showCancelButton: false,
                            showConfirmButton: false,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                    }
                }
                else if (message.responseJSON.input_errors && message.responseJSON.input_errors.length > 0) {

                    message.responseJSON.input_errors.forEach(element => {

                        if (element.input_name.includes('.')) {
                            const value = element.input_name.split('.');
                            $('.invalid.' + value[0]).eq(value[1]).html(element.message);
                        } else {
                            $('.invalid.' + element.input_name).html(element.message);
                        }

                        Swal.fire({
                            title: element.message,
                            icon: 'error',
                            timer: 3000,
                            toast: true,
                            position: 'top-right',
                            showCancelButton: false,
                            showConfirmButton: false,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                    });
                }
                else {
                    console.log('err3');
                    for (const key in message.responseJSON.errors) {
                        if (key.includes('.')) {
                            let val = key.replace(key.slice(-2), '');
                            $('.invalid.' + val).html(message.responseJSON, errors[key]);
                        } else {
                            $('.invalid.' + key).html(message.responseJSON.errors[key]);
                        }
                    }
                }
            }
        }
    });
    return false;
}

function apiConfirmRequestData(url, method = 'get', object_data, title='ต้องการยืนยันใช่หรือไม่ ?', display_option={}) {

    let confirm_color = '#7066e0';
    if( display_option.theme=='danger' ){
        confirm_color = '#dc3545';
    }

    let confirm_text = 'ยืนยัน';
    if( display_option.confirm_text && display_option.confirm_text!='' ){
        confirm_text = display_option.confirm_text;
    }

    return new Promise(function (resolve, reject) {
        Swal.fire({
            title: title,
            icon: 'question',
            backdrop: true,
            padding: '1em',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonColor: confirm_color,
            confirmButtonText: confirm_text,
            cancelButtonText: 'ยกเลิก',
            showLoaderOnConfirm: true,
            allowOutsideClick: false, // ไม่ให้คลิกภายนอกเพื่อปิด Alert
            preConfirm: () => {
                return $.ajax({
                    type: method,
                    url: url,
                    traditional: true,
                    contentType: false,
                    processData: false,
                    data: object_data,
                }).then(function (response) {
                    if (response.status === true) {
                        Swal.fire({
                            title: response.message,
                            icon: 'success',
                            timer: 2000,
                            toast: true,
                            position: 'top-right',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        resolve(response); // ส่ง Promise กลับเมื่อทุกรายการสำเร็จ
                    } else {
                        Swal.fire({
                            title: response.message,
                            icon: 'error',
                            timer: 2000,
                            toast: true,
                            position: 'top-right',
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        reject(response); // ปฏิเสธ Promise หากเจอข้อผิดพลาด
                    }
                }).catch(function (resp) {
                    const error = resp.responseJSON;
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด',
                        icon: 'error',
                        text: error.message,
                    });
                    // if( error.errors && error.errors.length>0 ){
                    //     error.errors.forEach(element => {
                    //         Swal.fire({
                    //             title: 'เกิดข้อผิดพลาด',
                    //             icon: 'error',
                    //             text: element.message,
                    //         });
                    //     });
                    // }
                    
                    console.error('AJAX Error:', error);
                    reject(error); // ปฏิเสธ Promise หากเกิดข้อผิดพลาดใน AJAX request
                });
            },
        });
    });
}

function formLoading(status) {
    if (status) {
        $('#modal-label-loading').show();
        $('#btnSubmit').attr('disabled', 'disabled');
        $('#form_field_submit').attr('disabled', 'disabled');
    } else {
        $('#modal-label-loading').hide();
        $('#btnSubmit').removeAttr('disabled');
        $('#form_field_submit').removeAttr('disabled');
    }
}

function formSubmitLoading(status) {
    if (status) {
        $('#btn_submit_loading').show();
        $('#btn_save').hide();
    } else {
        $('#btn_submit_loading').hide();
        $('#btn_save').show();
    }
    formLoading(status);
}

// show modal for create new item
function createModal(modalName) {
    $('#' + modalName + ' #form input:not([type="radio"])').val('');
    $('#' + modalName + ' #form textarea').val('');
    $('#' + modalName + ' #form select').attr('selectedIndex', 0);
    $('#' + modalName).modal('show');
}


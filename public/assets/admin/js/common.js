"use strict";
function confirmDelete(event, url, msg) {
    event.preventDefault();

    // Use the passed message or fallback to a default
    const message = msg || 'Are you sure you want to delete this item?';

    Swal.fire({
        title: 'Are you sure?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1B1B1B',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Confirm!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $('.overlay').css('display', 'block');
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;

            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Add method field for Laravel
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'GET';

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function ajaxCall(url, method, params) {

    return new Promise((resolve, reject) => {

        let requestObject = {
            url: url,
            method: method,
            data: params,
            // processData: false,
            // contentType: false,
            dataType: 'json',
            beforeSend: function () {
                // jQuery('.show_btn_loader').removeClass('d-none');
                $('.overlay').css('display', 'block');
            },
            complete: function (resp, status) {
                // jQuery('.show_btn_loader').addClass('d-none');
                $('.overlay').css('display', 'none');

            },
            success: function (response) {
                resolve(response)
            },
            error: function (error) {
                reject(error)
            }
        };
        requestObject.headers = {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        };
        if (params instanceof FormData) {
            requestObject.processData = requestObject.contentType = false;
            delete requestObject.dataType;
        }
        // console.log( requestObject );
        jQuery.ajax(requestObject);
    });

}

function toastMsg_old(typeToast, msg,bgColor) {

    const notyf = new Notyf({
        position: {
            x: 'right',
            y: 'top',
        },
        types: [{
            type: typeToast,
            background: bgColor,
            icon: {
                className: 'fas fa-times',
                tagName: 'span',
                color: '#fff'
            },
            dismissible: false
        }]
    });
    notyf.open({
        type: typeToast,
        message: msg,
    });
}

function toastMsg(typeToast, msg, bgColor) {
    const notyf = new Notyf({
        position: {
            x: 'right',
            y: 'top',
        },
        types: [{
            type: typeToast,
            background: bgColor || (typeToast === 'success' ? '#262B40' : (typeToast === 'error' ? '#FA5252' : (typeToast === 'warning' ? '#F5B759' : '#262B40'))), // Default bgColor based on type
            icon: {
                className:
                    typeToast === 'success'
                        ? 'fas fa-check-circle'
                        : typeToast === 'error'
                        ? 'fas fa-ban'
                        : typeToast === 'warning'
                        ? 'fas fa-exclamation-triangle'
                        : 'fas fa-info-circle', // Default icon
                tagName: 'span',
                color: '#fff'
            },
            dismissible: true
        }],
        duration: 5000,
    });

    notyf.open({
        type: typeToast,
        message: msg,
    });
}


$(document).on("click", ".input-group-text .fa-solid.fa-eye-slash, .input-group-text .fa-solid.fa-eye", function () {
    $(this).toggleClass("fa-eye-slash fa-eye");
    $(this).closest(".input-group").find("input[type='password'], input[type='text']").attr("type", function (index, attr) {
        return attr === "password" ? "text" : "password";
    });
});


/**Toggle status */
function toggleStatus(element, model, id, field=null, message=null) {
    jQuery(element).attr('disabled', true)
    let params = { 'id': id, 'model': model, 'field':field, 'message':message };
    let url = APP_URL + "/status/update";
    let response = ajaxCall(url, 'post', params);
    response.then(function (result) {
        // toastr.options.closeButton = true;
        // toastr.options.closeMethod = 'fadeOut';
        // toastr.options.closeDuration = 10;
        jQuery(element).attr('disabled', false)

        if (result.status == 'success') {
            toastMsg('success', result?.message || 'Successfully activated.')
            //return toastr.success(result.message);
        }
        else {
            toastMsg('error', result?.message);
            //return toastr.error(result.message);
        }
    }).catch(function (error) {
        $(element).prop("checked", !$(element).prop("checked"));
        return toastMsg('error', error?.message);
    })
}




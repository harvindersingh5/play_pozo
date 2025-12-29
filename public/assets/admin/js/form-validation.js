
jQuery.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');

jQuery.validator.addMethod("regex", function (value, element, regexp) {
    if (regexp.constructor != RegExp) {
        regexp = new RegExp(regexp);
    } else if (regexp.global) {
        regexp.lastIndex = 0;
    }

    return this.optional(element) || regexp.test(value);
}, "Enter a valid value");

function handleValidation(form, rules, messages = {}) {
    jQuery('form#' + form).validate({
        errorClass: "invalid-feedback",
        errorElement: 'span',
        ignore: "",
        rules: rules,
        messages: messages,
        highlight: function (element) {
            jQuery(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            jQuery(element).removeClass("is-invalid");
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") === "permissions[]") {
                error.insertAfter(element.closest('.col-md-12').find('label[for="permissions"]').closest('.mb-3'));
            } else if(element.attr("id") === 'logo_image' || element.attr("id") === 'favicon_image'){
                error.insertAfter(element.closest('.d-flex.align-items-center'));
            } 
            else {
                error.insertAfter(element);
            }
        }

    });
}

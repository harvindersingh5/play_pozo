<script>
    jQuery(document).ready(function() {
        const rules = {
            name: {
                required: true,
                minlength: firstNametMinLength,
                maxlength: firstNameMaxLength,
                regex: firstNameRegex,
            },
            status: {
                required: true,
            },
            // parent_id: {
            //     required: true,
            // },

        }
        const messages = {
            name: {
                required: `{{ __('custom_messages.category.required', ['attribute' => 'name']) }}`,
                minlength: `{{ __('custom_messages.category.min', ['attribute' => 'category name', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.category.max', ['attribute' => 'category name', 'max' => '50']) }}`,
                regex: `{{ __('custom_messages.category.regex', ['attribute' => 'category name']) }}`,
            },
            status: {
                required: `{{ __('custom_messages.category.required', ['attribute' => 'status']) }}`,
            },
            // parent_id: {
            //     required: `{{ __('custom_messages.category.required', ['attribute' => 'parent category']) }}`,
            // },

        };

        handleValidation('create-category', rules, messages);

        let isValid = true;

        jQuery("#category_image").change(function() {
            isValid = checkFile(this);
        });

        $('#create-category').on('submit', function(event) {
            if ($('#create-category').valid() && isValid) {
                $('.save-all-btn').prop('disabled', true);
                $('.overlay').css('display', 'block');
            } else {
                event.preventDefault();
            }
        });

        function checkFile(input) {
            const file = input.files[0];
            if (file) {
                const fileSize = file.size / 1024 / 1024; // in MB
                const fileType = file.type;

                const cardElement = $(input).closest('.error-div-box');

                if (fileSize > 2) {
                    cardElement.find(".fileSizeError").removeClass('d-none');
                    cardElement.find(".fileTypeError").addClass('d-none');
                    input.value = "";
                    return false;
                }

                if (!["image/png", "image/jpg", "image/jpeg"].includes(fileType)) {
                    cardElement.find(".fileTypeError").removeClass('d-none');
                    cardElement.find(".fileSizeError").addClass('d-none');
                    input.value = "";
                    return false;
                }

                cardElement.find(".fileSizeError").addClass('d-none');
                cardElement.find(".fileTypeError").addClass('d-none');

                let reader = new FileReader();
                reader.onload = function(event) {
                    if (input.id === "category_image") {
                        jQuery(".category-preview-image").attr("src", event.target.result);
                    }
                };
                reader.readAsDataURL(file);

                return true;
            }
            return false;
        }

    });
</script>

<script>
    jQuery(document).ready(function() {
        const rules = {
            name: {
                required: true,
                minlength: 3,
                maxlength: 255
            },
            type: {
                required: true
            },
            value: {
                required: true,
                number: true,
            }
        }
        const messages = {
            name: {
                required: "Commission name is required.",
                maxlength: "Commission name cannot be more than 255 characters."
            },
            type: {
                required: "Commission type is required."
            },
            value: {
                required: "Commission value is required.",
                number: "Please enter a valid number for the commission value."
            }

        };

        handleValidation('edit-commission', rules, messages);

        $('#edit-commission').on('submit', function(event) {
            if ($('#edit-commission').valid()) {
                $('.save-all-btn').prop('disabled', true);
                $('.overlay').css('display', 'block');
            } else {
                event.preventDefault();
            }
        });

    });
</script>

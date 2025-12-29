<script>
    jQuery(document).ready(function() {
        const rules = {
            name: {
                required: true,
                minlength: planNameMinLength,
                maxlength: planNameMaxLength,
                regex: planNameRegex,
            },
            price: {
                required: true,
                number: true,
                min: 0,
            },
            validity: {
                required: true
            },
            description: {
                required: true
            },
            status: {
                required: true
            }
        };

        const messages = {
            name: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'plan name']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'plan name', 'min' => '${planNameMinLength}']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'plan name', 'max' => '${planNameMaxLength}']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'plan name']) }}`,
            },
            price: {
                required: "Price is required.",
                number: "Please enter a valid number for the price.",
                min: "Price cannot be negative."
            },
            validity: {
                required: "Please select a validity."
            },
            description: {
                required: "Description is required."
            },
            status: {
                required: "Please select a status."
            }
        };

        handleValidation('plan-form', rules, messages);

        $('#plan-form').on('submit', function(event) {
            if ($('#plan-form').valid()) {
                $('.save-all-btn').prop('disabled', true);
                $('.overlay').css('display', 'block');
            } else {
                event.preventDefault();
            }
        });
    });
</script>

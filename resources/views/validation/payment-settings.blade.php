<script>
    jQuery(document).ready(function() {
        const rules = {
            // public_key and secret_key (stripe)
            public_key: {
                required: true,
                minlength: 2,
                maxlength: 255
            },
            secret_key: {
                required: true,
                minlength: 2,
                maxlength: 255
            },

        }
        const messages = {
            public_key: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'public key']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'public key', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'public key', 'max' => '255']) }}`,
            },
            secret_key: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'secret key']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'secret key', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'secret key', 'max' => '255']) }}`,
            },

        };

        handleValidation('payment-settings', rules, messages);

        $('#payment-settings').on('submit', function(event) {
            if ($('#payment-settings').valid()) {
                $('.save-all-btn').prop('disabled', true);
                $('.overlay').css('display', 'block');
            } else {
                event.preventDefault();
            }
        });

    });
</script>

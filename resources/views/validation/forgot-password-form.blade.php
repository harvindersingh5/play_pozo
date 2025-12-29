<script>
    jQuery(document).ready(function() {
        const rules = {
            email: {
                required: true,
                email: true,
                maxlength: emailMaxLength,
                regex: emailRegex,
            }
        };

        const messages = {
            email: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'email']) }}`,
                email: `{{ __('custom_messages.user.email', ['attribute' => 'email']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'email']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'email', 'max' => '${emailMaxLength}']) }}`,
            }
        };

        handleValidation('forgot-password-form', rules, messages);
    });
</script>
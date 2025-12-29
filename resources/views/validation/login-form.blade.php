<script>
    jQuery(document).ready(function() {
        const rules = {
            email: {
                required: true,
                email: true,
                maxlength: emailMaxLength,
                regex: emailRegex,
            },
            password: {
                required: true,
                minlength: 8,
                maxlength: 32,
            }
        };

        const messages = {
            email: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'email']) }}`,
                email: `{{ __('custom_messages.user.email', ['attribute' => 'email']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'email']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'email', 'max' => '254']) }}`,
            },
            password: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'password']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'password', 'min' => '${passwordMinLength}']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'password', 'max' => '${passwordMaxLength}']) }}`,
            }
        };

        handleValidation('login-form', rules, messages);
    });
</script>
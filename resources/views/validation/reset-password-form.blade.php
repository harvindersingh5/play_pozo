<script>
    jQuery(document).ready(function() {
        const rules = {
             password: {
                required: true,
                minlength: passwordMinLength,
                maxlength: passwordMaxLength,
                regex: passwordRegex,
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
        };

        const messages = {
             password: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'password']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'password', 'min' => '${passwordMinLength}']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'password', 'max' => '${passwordMaxLength}']) }}`,
                regex: `{{ __('custom_messages.user.password_regex', ['attribute' => 'password']) }}`,
            },
            password_confirmation: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'confirm password']) }}`,
                equalTo: `{{ __('custom_messages.user.same', ['attribute' => 'password', 'other' => 'confirm password']) }}`,
            },
        };

        handleValidation('reset-password-form', rules, messages);
    });
</script>
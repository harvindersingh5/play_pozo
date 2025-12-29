<script>
    jQuery(document).ready(function() {
        const rules = {
            current_password: {
                required: true,
                minlength: passwordMinLength,
                maxlength: passwordMaxLength,
                regex: passwordRegex,
            },
            password: {
                required: true,
                minlength: passwordMinLength,
                maxlength: passwordMaxLength,
                regex: passwordRegex,
            },
            confirm_password: {
                required: true,
                equalTo: "#cPassword"
            },
        }
        const messages = {
            current_password: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'password']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'password', 'min' => '8']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'password', 'max' => '50']) }}`,
                regex: `{{ __('custom_messages.user.password_regex', ['attribute' => 'password']) }}`,
            },
            password: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'password']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'password', 'min' => '8']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'password', 'max' => '50']) }}`,
                regex: `{{ __('custom_messages.user.password_regex', ['attribute' => 'password']) }}`,
            },
            confirm_password: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'confirm password']) }}`,
                equalTo: `{{ __('custom_messages.user.same', ['attribute' => 'password', 'other' => 'confirm password']) }}`,
            },

        };

        handleValidation('update-password', rules, messages);

    });
</script>

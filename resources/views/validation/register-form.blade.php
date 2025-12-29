<script>
    jQuery(document).ready(function() {
        const rules = {
            name: {
                required: true,
                minlength: firstNametMinLength,
                maxlength: firstNameMaxLength,
                regex: firstNameRegex,
            },
            email: {
                required: true,
                email: true,
                maxlength: emailMaxLength,
                regex: emailRegex,
                remote: { 
                    url: "{{ route('register.check-email') }}", 
                    type: "post",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: function() {
                            return $("#email").val();
                        }
                    }
                }
            },
            password: {
                required: true,
                minlength: passwordMinLength,
                maxlength: passwordMaxLength,
                regex: passwordRegex,
            },
            password_confirmation: {
                required: true,
                equalTo: "#password",
            }
        };

        const messages = {
            name: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'name']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'name', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'name', 'max' => '50']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'name']) }}`,
            },
            email: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'email']) }}`,
                email: `{{ __('custom_messages.user.email', ['attribute' => 'email']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'email']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'email', 'max' => '${emailMaxLength}']) }}`,
                remote: "This email address is already taken."
            },
            password: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'password']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'password', 'min' => '${passwordMinLength}']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'password', 'max' => '${passwordMaxLength}']) }}`,
                regex: `{{ __('custom_messages.user.password_regex', ['attribute' => 'password']) }}`,
            },
            password_confirmation: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'confirm password']) }}`,
                equalTo: `{{ __('custom_messages.user.same', ['attribute' => 'password', 'other' => 'confirm password']) }}`,
            }
        };

        handleValidation('register-form', rules, messages);
    });
</script>
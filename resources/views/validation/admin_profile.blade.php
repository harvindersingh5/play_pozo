<script>
    jQuery(document).ready(function() {
        const rules = {
            first_name: {
                required: true,
                minlength: firstNametMinLength,
                maxlength: firstNameMaxLength,
                regex: firstNameRegex,
            },
            last_name: {
                required: true,
                minlength: lastNametMinLength,
                maxlength: lastNameMaxLength,
                regex: lastNameRegex,
            },
            email: {
                required: true,
                email: true,
                maxlength: emailMaxLength,
                regex: emailRegex,
            },
            gender:{
                required: true,
            },
            address: {
                // required: true,
                minlength: addressMinLength,
                maxlength: addressMaxLength,
            },
            postal_code: {
                // required: true,
                minlength: postalCodeMinLength,
                maxlength: postalCodeMaxLength,
                regex: postalCodeRegex,
            },
            phone_number: {
                // required: true,
                regex: phoneRegex,
            },
        }
        const messages = {
            first_name: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'first name']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'first name', 'min' => '${firstNametMinLength}']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'first name', 'max' => '${firstNameMaxLength}']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'first name']) }}`,
            },
            last_name: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'last name']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'last name', 'min' => '${lastNametMinLength}']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'last name', 'max' => '${lastNameMaxLength}']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'last name']) }}`,
            },
            email: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'email']) }}`,
                email: `{{ __('custom_messages.user.email', ['attribute' => 'email']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'email']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'email', 'max' => '${emailMaxLength}']) }}`,
            },
            phone_number: {
                regex: `{{ __('custom_messages.user.phone_number', ['attribute' => 'phone number']) }}`,
            },
            gender: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'Gender']) }}`,
            },
            address: {
                // required: `{{ __('custom_messages.user.required', ['attribute' => 'address']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'address', 'min' => '${addressMinLength}']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'address', 'max' => '${addressMaxLength}']) }}`,
            },
            postal_code: {
                // required: `{{ __('custom_messages.user.required', ['attribute' => 'postal code']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'postal code', 'min' => '${postalCodeMinLength}']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'postal code', 'max' => '${postalCodeMaxLength}']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'postal code']) }}`,
            },
            phone_number: {
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'phone number']) }}`,
            },
        };

        handleValidation('update-admin-profile', rules, messages);

    });
</script>

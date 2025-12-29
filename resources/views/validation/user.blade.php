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
            phone_number: {
                regex: phoneRegex,
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
            address: {
                required: true,
                minlength: addressMinLength,
                maxlength: addressMaxLength,
                regex: addressRegex,
            },
            country: {
                required: true,
                // minlength: countryNametMinLength,
                // maxlength: countryNameMaxLength,
                // regex: countryNameRegex,
            },
            state: {
                required: true,
                // minlength: stateNametMinLength,
                // maxlength: stateNameMaxLength,
                // regex: stateNameRegex,
            },
            city: {
                required: true,
                // minlength: firstNametMinLength,
                // maxlength: firstNameMaxLength,
                // regex: firstNameRegex,
            },
            postal_code: {
                required: true,
                minlength: postalCodeMinLength,
                maxlength: postalCodeMaxLength,
                regex: postalCodeRegex,
            },
            gender:{
                required: true,
            },


        }
        const messages = {
            first_name: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'first name']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'first name', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'first name', 'max' => '50']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'first name']) }}`,
            },
            last_name: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'last name']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'last name', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'last name', 'max' => '50']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'last name']) }}`,
            },
            email: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'email']) }}`,
                email: `{{ __('custom_messages.user.email', ['attribute' => 'email']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'email']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'email', 'max' => '254']) }}`,
            },
            phone_number: {
                regex: `{{ __('custom_messages.user.phone_number', ['attribute' => 'phone number']) }}`,
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
            address: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'address']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'address', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'address', 'max' => '100']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'address']) }}`,
            },
            country: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'country']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'country', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'country', 'max' => '50']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'country']) }}`,
            },
            state: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'state']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'state', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'state', 'max' => '50']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'state']) }}`,
            },
            city: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'city']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'city', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'city', 'max' => '50']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'city']) }}`,
            },
            postal_code: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'zip code']) }}`,
                minlength: `{{ __('custom_messages.user.min', ['attribute' => 'zip code', 'min' => '2']) }}`,
                maxlength: `{{ __('custom_messages.user.max', ['attribute' => 'zip code', 'max' => '20']) }}`,
                regex: `{{ __('custom_messages.user.regex', ['attribute' => 'zip code']) }}`,
            },
            gender: {
                required: `{{ __('custom_messages.user.required', ['attribute' => 'Gender']) }}`,
            },
        };

        handleValidation('create-user', rules, messages);

    });
</script>

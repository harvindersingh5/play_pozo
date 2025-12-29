<script>
    const APP_NAME = "{{ config('app.name', 'Laravel12') }}";
    const APP_URL = "{{ url('') }}";
    const csrf = jQuery("meta[ name='csrf-token']").attr("content");
    // First name
    const firstNameRegex = {{ config('validation.first_name_regex') }};
    const firstNametMinLength = {{ config('validation.first_name_minlength') }};
    const firstNameMaxLength = {{ config('validation.first_name_maxlength') }};

    // //Last Name
    const lastNameRegex = {{ config('validation.last_name_regex') }};
    const lastNametMinLength = {{ config('validation.last_name_minlength') }};
    const lastNameMaxLength = {{ config('validation.last_name_maxlength') }};

    //email
    const emailRegex = {{ config('validation.email_regex') }};
    const emailMaxLength = {{ config('validation.email_maxlength') }};

    //password
    const passwordRegex = {{ config('validation.password_regex') }};
    const passwordMinLength = parseInt(`${passwordRegex}`.match(/(?<={)\d+/)[0]);
    const passwordMaxLength = parseInt(`${passwordRegex}`.match(/\d+(?=})/)[0]);

    //postal code
    const postalCodeRegex = {{ config('validation.postal_regex') }};
    const postalCodeMinLength = {{ config('validation.postal_minlength') }};
    const postalCodeMaxLength = {{ config('validation.postal_maxlength') }};
    //address
    const addressRegex = {{ config('validation.address_regex') }};
    const addressMinLength = parseInt(`${addressRegex}`.match(/(?<={)\d+/)[0]);
    const addressMaxLength = parseInt(`${addressRegex}`.match(/\d+(?=})/)[0]);

    // country
    const countryNameRegex = {{ config('validation.country_name_regex') }};
    const countryNametMinLength = {{ config('validation.country_name_minlength') }};
    const countryNameMaxLength = {{ config('validation.country_name_maxlength') }};

    // state
    const stateNameRegex = {{ config('validation.state_name_regex') }};
    const stateNametMinLength = {{ config('validation.state_name_minlength') }};
    const stateNameMaxLength = {{ config('validation.state_name_maxlength') }};

    //city
    const cityNameRegex = {{ config('validation.city_name_regex') }};
    const cityNametMinLength = {{ config('validation.city_name_minlength') }};
    const cityNameMaxLength = {{ config('validation.city_name_maxlength') }};

    //phone
    const phoneRegex = {{ config('validation.phone_regex') }};
    const phoneMinLength = {{ config('validation.phone_minlength') }};
    const phoneMaxLength = {{ config('validation.phone_maxlength') }};
    //profile
    const profilePicMimes = "{{ config('validation.js_profile_pic_mimes') }}";
    const profilePicSize = "{{ config('validation.js_profile_pic_size') }}";

    //message
    // const messageMinLength = {{ config('validation.message_minlength') }};
    // const messageMaxLength = {{ config('validation.message_maxlength') }};

    //Plan
    const planNameRegex = {{ config('validation.plan_name_regex') }};
    const planNameMinLength = {{ config('validation.plan_name_minlength') }};
    const planNameMaxLength = {{ config('validation.plan_name_maxlength') }};

</script>

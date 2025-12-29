<?php
return [
        'first_name_regex' => '/^[a-zA-Z]+[a-zA-Z\s]{1,50}$/',
        'first_name_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s]{2,50}$/',
        'first_name_minlength' => 2,
        'first_name_maxlength' => 50,

        'last_name_regex' => '/^[a-zA-Z]+[a-zA-Z\s]{1,50}$/',
        'last_name_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s]{2,50}$/',
        'last_name_minlength' => 2,
        'last_name_maxlength' => 50,


        'postal_regex' => '/^[a-zA-Z0-9\s]{1,20}$/',
        'postal_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s]{2,20}$/',
        'postal_minlength' => 1,
        'postal_maxlength' => 20,

        'location_regex' => '/^[a-zA-Z0-9]+[a-zA-Z\s\d@#&:,.]{1,50}$/',
        'location_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s\d@#&:,.]{2,50}$/',
        'location_minlength' => 2,
        'location_maxlength' => 50,

        'address_regex' => '/^[a-zA-Z0-9\s\d@#&:,]{2,50}$/',
        'address_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s\d@#&:,.]{2,50}$/',
        'address_minlength' => 2,
        'address_maxlength' => 50,

        'phone_regex' => '/^(\([0-9]{3}\)|[0-9]{3})[\s\-]?[\0-9]{3}[\s\-]?[0-9]{4}$/',
        'phone_minlength' => 10,
        'phone_maxlength' => 10,

        // 'message_minlength' => 10,
        // 'message_maxlength' => 300,

        'php_profile_pic_mimes' => 'jpg,jpeg,png',
        'js_profile_pic_mimes' => 'jpg|jpeg|png',


        'php_profile_pic_size' => '2000',
        'js_profile_pic_size' => '2097152',
        'js_profile_pic_size' => '2000000',

        'email_regex' => '/^(?=.{1,254}$)[a-zA-Z0-9]+([._+-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([._-][a-zA-Z0-9]+)*\.[a-zA-Z]{2,10}$/',
        'email_regex_message' =>  '/^[a-zA-Z]+(?!.*[\_\-\.]{2}).*[a-zA-Z0-9_\.\-]{2,}[a-zA-Z0-9]{1}@[a-zA-Z]+(\.[a-zA-Z]+)?[\.]{0}[a-zA-Z]{2,10}$/',
        'email_maxlength' => '254',

        'password_regex' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d!@#$%^&*]{8,32}$/',
        'password_regex_message' =>  '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d!@#$%^&*]{8,32}$/',
        'password_minlength' => 8,
        'password_maxlength' => 32,

        // country
        'country_name_regex' => '/^[a-zA-Z]+[a-zA-Z\s]{1,50}$/',
        'country_name_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s]{2,50}$/',
        'country_name_minlength' => 2,
        'country_name_maxlength' => 50,

        // state
        'state_name_regex' => '/^[a-zA-Z]+[a-zA-Z\s]{1,50}$/',
        'state_name_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s]{2,50}$/',
        'state_name_minlength' => 2,
        'state_name_maxlength' => 50,

        // city
        'city_name_regex' => '/^[a-zA-Z]+[a-zA-Z\s]{1,50}$/',
        'city_name_regex_message' =>  '/^[a-zA-Z]+[a-zA-Z\s]{2,50}$/',
        'city_name_minlength' => 2,
        'city_name_maxlength' => 50,

        // Plan
        'plan_name_regex' => '/^[a-zA-Z]+[a-zA-Z\s]{1,50}$/',
        'plan_name_minlength' => 2,
        'plan_name_maxlength' => 50,
        
        'full_name' => [
                'min' => 2,
                'max' => 100,
        ],
        'email' => [
                'max' => 255,
                // 'regex' => '/^[a-zA-Z]+(?!.*[\_\-\.]{2}).*[a-zA-Z0-9_\.\-]{1,}[a-zA-Z0-9]{1}@[0-9]{0,1}?[a-zA-Z]+(\.[a-zA-Z]+)?[\.]{1}[a-zA-Z]{2,10}$/',
                'regex' => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\\.,;:\s@"]+\.)+[^<>()[\]\\.,;:\s@"]{2,})$/i',
        ],
        'phone_number_country_code' => [
                'regex' => '/^\+\d{1,4}$/',
        ],
        'phone_number' => [
                'regex' => '/^\d{10}$/'
        ],
        'password' => [
                'regex' => '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,32}$/'
        ]
];

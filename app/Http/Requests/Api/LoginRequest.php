<?php

namespace App\Http\Requests\Api;

use App\Rules\PhoneOrEmail;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rules;

class LoginRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone_email' => [
                'required',
                'string',
                new PhoneOrEmail()
            ],

            'phone_country_code' => [
                'nullable',
                'string',
                'regex:' . config('validation.phone_number_country_code.regex'),
            ],

            'password' => [
                'required',
                'string',
                Rules\Password::defaults(),
            ],
        ];
    }


    /***
     * Validation messages
     */
    public function messages(): array
    {
        return [
            // phone_email
            'phone_email.required' => __('validation.custom.phone_email.required'),
            'phone_email.string'   => __('validation.custom.phone_email.string'),
            'phone_email.phone_or_email' => __('validation.custom.phone_email.phone_or_email'), // for custom rule message

            // phone_country_code
            'phone_country_code.string' => __('validation.custom.phone_country_code.string'),
            'phone_country_code.regex'  => __('validation.custom.phone_country_code.regex'),

            // password
            'password.required' => __('validation.custom.password.required'),
            'password.string'   => __('validation.custom.password.string'),
            'password.regex'    => __('validation.custom.password.regex'),
        ];
    }
}

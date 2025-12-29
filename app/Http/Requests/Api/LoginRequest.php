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
                // 'required_with:phone_number',
                // 'required_without:email',
            ],

            // 'phone_number' => [
            //     'nullable',
            //     'string',
            //     'digits_between:6,15',
            //     'required_with:phone_country_code',
            //     'required_without:email',
            // ],

            'password' => [
                'required',
                'string',
                Rules\Password::defaults(),
            ],
        ];
    }
}

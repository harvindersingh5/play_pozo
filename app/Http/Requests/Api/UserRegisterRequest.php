<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserRegisterRequest extends BaseRequest
{
    /***
     * set phone_code and number into a single field
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone_e164' => $this->phone_country_code . $this->phone_number,
        ]);
    }



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
            'full_name' => [
                'required',
                'string',
                'min:' . config('validation.full_name.min'),
                'max:' . config('validation.full_name.max')
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:' . config('validation.email.max'),
                'unique:users,email',
                'regex:' . config('validation.email.regex'),
                // 'required_without:phone_number, phone_country_code',
            ],

            'phone_country_code' => [
                'required',
                'string',
                'regex:' . config('validation.phone_number_country_code.regex'),
                // 'required_with:phone_number',
                // 'required_without:email',
            ],

            'phone_number' => [
                'required',
                'string',
                // 'digits_between:6,15',
                'regex:' . config('validation.phone_number.regex'),
                // 'required_with:phone_country_code',
                // 'required_without:email',
            ],

            'phone_e164'  => [
                'required',
                Rule::unique('user_details', 'phone_e164'),
            ],

            'password' => [
                'required',
                'confirmed',
                // 'regex:'.config('validation.password.regex'),
                Rules\Password::defaults()
            ],
            'password_confirmation' => [
                'required_with:password',
                'string',
            ],
        ];
    }



    /***
     * Validation messages
     */
    public function messages(): array
    {
        return [
            'phone_e164.unique' => 'Phone number is already registered.',
        ];
    }
}

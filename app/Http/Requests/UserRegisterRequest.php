<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Traits\CustomRequestFunction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;


class UserRegisterRequest extends FormRequest
{
    //To check phone_number must be unique because dial_code and number are stored single single
    use CustomRequestFunction;

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
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class
            ],
            'phone_country_code' => [
                'nullable',
                'string',
                'regex:' . config('validation.phone_number_country_code.regex'),
                'required_with:phone_number',
            ],
            'phone_number' => [
                'nullable',
                'string',
                'regex:' . config('validation.phone_number.regex'),
                'required_with:phone_country_code',
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],
        ];
    }
}

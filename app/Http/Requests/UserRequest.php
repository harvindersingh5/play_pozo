<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules = [
            'first_name' => ['required', 'min:' . config("validation.first_name_minlength"), 'max:' . config("validation.first_name_maxlength"),'regex:'.config('validation.first_name_regex')],
            'last_name' => ['required', 'min:' . config("validation.last_name_minlength"), 'max:' . config("validation.last_name_maxlength"),'regex:'.config('validation.last_name_regex')],
            'email' => ['required', 'unique:users,email', 'email', 'regex:' . config("validation.email_regex")],
            'phone_number' => ['nullable', 'regex:' . config("validation.phone_regex")],
            'password' => ['required', 'same:confirm_password', 'min:' . config("validation.password_minlength"), 'max:' . config("validation.password_maxlength"), 'regex:' . config("validation.password_regex")],
            'confirm_password' => ['required'],
            'address' => ['required', 'min:' . config("validation.address_minlength"), 'max:' . config("validation.address_maxlength"),'regex:'.config('validation.address_regex')],
            // 'country' =>  ['required', 'min:' . config("validation.country_name_minlength"), 'max:' . config("validation.country_name_maxlength"),'regex:'.config('validation.country_name_regex')],
            // 'state' =>  ['nullable', 'min:' . config("validation.state_name_minlength"), 'max:' . config("validation.state_name_maxlength"),'regex:'.config('validation.state_name_regex')],
            // 'city' =>  ['nullable', 'min:' . config("validation.city_name_minlength"), 'max:' . config("validation.city_name_maxlength"),'regex:'.config('validation.city_name_regex')],
            // country, state, city are required for id and should be exists in their respective tables
            'country' => ['required', 'exists:countries,id'],
            'state' => ['required', 'exists:states,id'],
            'city' => ['required', 'exists:cities,id'],
            'postal_code' => ['required', 'min:' . config("validation.postal_minlength"), 'max:' . config("validation.postal_maxlength"), 'regex:' . config("validation.postal_regex")],
            'gender' => ['required'],
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'back_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',

        ];

        if(request()->route()->parameter('id')){
            $userId = request()->route()->parameter('id');
            $user = User::where('id', jsdecode_userdata($userId))->first();
            $rules['email'][1] .= ',' . $user->id;
            // $rules['password'][0] = 'nullable';
            // $rules['confirm_password'][0] = 'nullable';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('custom_messages.user.required', ['attribute' => 'first name']),
            'first_name.min' => __('custom_messages.user.min', ['attribute' => 'first name', 'min' => config("validation.first_name_minlength")]),
            'first_name.max' => __('custom_messages.user.max', ['attribute' => 'first name', 'max' => config("validation.first_name_maxlength")]),
            'first_name.regex' => __('custom_messages.user.regex', ['attribute' => 'first name']),

            'last_name.required' => __('custom_messages.user.required', ['attribute' => 'last name']),
            'last_name.min' => __('custom_messages.user.min', ['attribute' => 'last name', 'min' => config("validation.last_name_minlength")]),
            'last_name.max' => __('custom_messages.user.max', ['attribute' => 'last name', 'max' => config("validation.last_name_maxlength")]),
            'last_name.regex' => __('custom_messages.user.regex', ['attribute' => 'last name']),

            'email.required' => __('custom_messages.user.required', ['attribute' => 'email']),
            'email.email' => __('custom_messages.user.email', ['attribute' => 'email']),
            'email.regex' => __('custom_messages.user.regex', ['attribute' => 'email']),

            'phone_number.regex' => __('custom_messages.user.regex', ['attribute' => 'phone number']),

            'password.required' => __('custom_messages.user.required', ['attribute' => 'password']),
            'password.min' => __('custom_messages.user.min', ['attribute' => 'password', 'min' => config("validation.password_minlength")]),
            'password.max' => __('custom_messages.user.max', ['attribute' => 'password', 'max' => config("validation.password_maxlength")]),
            'password.regex' => __('custom_messages.user.regex', ['attribute' => 'password']),
            'password.same' => __('custom_messages.user.same', ['attribute' => 'password']),

            'confirm_password.required' => __('custom_messages.user.required', ['attribute' => 'confirm password']),

            'address_name.required' => __('custom_messages.user.required', ['attribute' => 'address']),
            'address_name.min' => __('custom_messages.user.min', ['attribute' => 'address', 'min' => config("validation.address_minlength")]),
            'address_name.max' => __('custom_messages.user.max', ['attribute' => 'address', 'max' => config("validation.address_maxlength")]),
            'address_name.regex' => __('custom_messages.user.regex', ['attribute' => 'address name']),

            'country.required' => __('custom_messages.user.required', ['attribute' => 'country']),
            'country.min' => __('custom_messages.user.min', ['attribute' => 'country', 'min' => config("validation.country_name_minlength")]),
            'country.max' => __('custom_messages.user.max', ['attribute' => 'country', 'max' => config("validation.country_name_maxlength")]),
            'country.regex' => __('custom_messages.user.regex', ['attribute' => 'country']),

            'state.required' => __('custom_messages.user.required', ['attribute' => 'state']),
            'state.min' => __('custom_messages.user.min', ['attribute' => 'state', 'min' => config("validation.state_name_minlength")]),
            'state.max' => __('custom_messages.user.max', ['attribute' => 'state', 'max' => config("validation.state_name_maxlength")]),
            'state.regex' => __('custom_messages.user.regex', ['attribute' => 'state']),

            'city.required' => __('custom_messages.user.required', ['attribute' => 'city']),
            'city.min' => __('custom_messages.user.min', ['attribute' => 'city', 'min' => config("validation.city_name_minlength")]),
            'city.max' => __('custom_messages.user.max', ['attribute' => 'city', 'max' => config("validation.city_name_maxlength")]),
            'city.regex' => __('custom_messages.user.regex', ['attribute' => 'city']),

            'postal_code.required' => __('custom_messages.user.required', ['attribute' => 'zip code']),
            'postal_code.min' => __('custom_messages.user.min', ['attribute' => 'zip code', 'min' => config("validation.postal_minlength")]),
            'postal_code.max' => __('custom_messages.user.max', ['attribute' => 'zip code', 'max' => config("validation.postal_maxlength")]),
            'postal_code.regex' => __('custom_messages.user.regex', ['attribute' => 'zip code']),

            'gender.required' => __('custom_messages.user.required', ['attribute' => 'Gender']),

        ];
    }
}

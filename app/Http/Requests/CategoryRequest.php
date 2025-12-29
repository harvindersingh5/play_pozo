<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:50',
            'status' => ['required', 'string', Rule::in(['ACTIVE', 'INACTIVE'])],
            'parent_id' => 'nullable|exists:categories,id',
            'category_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('custom_messages.category.required', ['attribute' => 'name']),
            'name.string' => __('custom_messages.category.string', ['attribute' => 'name']),
            'name.min' => __('custom_messages.category.min', ['attribute' => 'name', 'min' => 2]),
            'name.max' => __('custom_messages.category.max', ['attribute' => 'name', 'max' => 50]),
            'status.required' => __('custom_messages.category.required', ['attribute' => 'status']),
            'status.string' => __('custom_messages.category.string', ['attribute' => 'status']),
            'status.in' => __('custom_messages.category.in', ['attribute' => 'status']),
            'parent_id.exists' => __('custom_messages.category.exists', ['attribute' => 'parent category']),
        ];
    }
}

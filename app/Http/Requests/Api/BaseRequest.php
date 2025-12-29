<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class BaseRequest extends FormRequest
{
    use ApiResponse;

    /***
     * Api error response
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->validationErrorResponse(
                $validator->errors()
            )
        );
    }


    protected function failedAuthorization()
    {
        throw new HttpResponseException(
            $this->unauthorizedResponse()
        );
    }
}

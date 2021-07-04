<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidationJsonResponse
{
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}

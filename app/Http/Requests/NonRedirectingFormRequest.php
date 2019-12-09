<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

/**
 * When the 'Accept: application/json' header is not passed with the request, Laravel automatically performs a redirect
 * on failed validation, because of how it handles the default validation exception. Using this subclass, you can force
 * your validators to always behave like they were triggered by JSON / AJAX requests.
 *
 * @package App\Http\Requests
 */
class NonRedirectingFormRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_BAD_REQUEST));
    }
}

<?php

namespace App\Services\ItemsValidator;

use Illuminate\Validation\Validator;

/**
 * Used to validate menu items storing requests.
 *
 * @todo Should be refactored into custom validation rules.
 * @package App\Services\ItemsValidator
 */
interface ItemsValidator
{
    public function validateRequestAndInjectErrors(Validator $validator): void;
}

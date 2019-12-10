<?php

namespace App\Http\Requests;

use App\Services\ItemsValidator\ItemsValidator;
use Illuminate\Validation\Validator;

/**
 * Request object for storing menu items.
 *
 * @package App\Http\Requests
 */
class StoreMenuItemsRequest extends NonRedirectingFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'data' => 'array'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->setData(['data' => $this->all()]);

        $validator->after(function (Validator $validator) {
            // FIXME hidden dependency
            /* @var ItemsValidator $itemsValidator */
            $itemsValidator = $this->container->make(ItemsValidator::class);
            $itemsValidator->validateRequestAndInjectErrors($validator);
        });
    }
}

<?php

namespace App\Http\Requests;

use App\Services\ItemsValidator\ItemsValidator;
use Illuminate\Validation\Validator;

/**
 * Base class for child item storing requests.
 *
 * @package App\Http\Requests
 */
abstract class AbstractStoreItemRequest extends NonRedirectingFormRequest
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
            $itemsValidator->validateRequestAndInjectErrors($validator, $this->getMenuId());
        });
    }

    /**
     * Use this method if you want to validate items against menu constraints.
     *
     * @return int|null
     */
    abstract protected function getMenuId(): ?int;
}

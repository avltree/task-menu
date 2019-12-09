<?php

namespace App\Http\Requests;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Validator;

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
            $items = $this->all();
            $errors = $validator->errors();

            if (empty($items)) {
                $errors->add('items', 'No valid items passed.');
            }

            $this->validateItems($items, $errors);
        });
    }

    /**
     * Method used for recursive item validation.
     *
     * @param array $items
     * @param MessageBag $errors
     * @param int $depth
     */
    private function validateItems(array $items, MessageBag $errors, int $depth = 0)
    {
        foreach ($items as $index => $item) {
            if (is_array($item)) {
                $validator = \Illuminate\Support\Facades\Validator::make($item, [
                    'field' => 'required|string',
                    'children' => 'array'
                ]);

                // FIXME prefix the error message
                $errors->merge($validator->errors());

                if (!empty($item['children']) && is_array($item['children'])) {
                    $this->validateItems($item['children'], $errors, $depth + 1);
                }
            } else {
                $errors->add(sprintf('item[%d][%d]', $depth, $index), 'Item is not an array.');
            }
        }
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Validation\Validator;

/**
 * Request object for updating the menus.
 *
 * @package App\Http\Requests
 */
class UpdateMenuRequest extends NonRedirectingFormRequest
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
            'field' => 'string|unique:menus',
            'max_depth' => 'integer|min:1|max:32767',
            'max_children' => 'integer|min:1|max:32767'
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            if (empty($validator->validated())) {
                $validator->errors()->add('field', 'Nothing to update.');
            }
        });
    }
}

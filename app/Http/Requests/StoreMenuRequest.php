<?php

namespace App\Http\Requests;

class StoreMenuRequest extends NonRedirectingFormRequest
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
            'field' => 'required|string|unique:menus',
            'max_depth' => 'integer|min:1|max:32767',
            'max_children' => 'integer|min:1|max:32767'
        ];
    }
}

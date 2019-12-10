<?php

namespace App\Http\Requests;

use App\Services\MenuRegistry\MenuRegistry;
use Illuminate\Support\MessageBag;
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
            $items = $this->all();
            $errors = $validator->errors();

            if (empty($items)) {
                $errors->add('items', 'No valid items passed.');
            }

            list($maxDepth, $maxLen) = $this->validateItems($items, $errors);
            // FIXME hidden dependency
            /* @var MenuRegistry $menuRegistry */
            $menuRegistry = $this->container->make(MenuRegistry::class);
            // Not worrying about nonexistent menus, because an exception will trigger an 404 error at this point
            $menu = $menuRegistry->findById($this->route()->parameter('id'));

            if ($maxDepth > $menu->max_depth) {
                $errors->add('items', sprintf('The items depth is %d, but max is %d.', $maxDepth, $menu->max_depth));
            }

            if ($maxLen > $menu->max_children) {
                $errors->add('items', sprintf('Items length is %d, but max is %d.', $maxLen, $menu->max_children));
            }
        });
    }

    /**
     * Method used for recursive item validation.
     *
     * @param array $items
     * @param MessageBag $errors
     * @param int $depth
     * @return array
     */
    private function validateItems(array $items, MessageBag $errors, int $depth = 1): array
    {
        $maxLen = count($items);
        $maxDepth = $depth;

        foreach ($items as $index => $item) {
            if (is_array($item)) {
                $validator = \Illuminate\Support\Facades\Validator::make($item, [
                    'field' => 'required|string',
                    'children' => 'array'
                ]);

                // FIXME prefix the error message
                $errors->merge($validator->errors());

                if (!empty($item['children']) && is_array($item['children'])) {
                    list($maxDepth, $childLen) = $this->validateItems($item['children'], $errors, $depth + 1);
                    $maxLen = $maxLen > $childLen ? $maxLen : $childLen;
                }
            } else {
                $errors->add(sprintf('item[%d][%d]', $depth, $index), 'Item is not an array.');
            }
        }

        return [$maxDepth, $maxLen];
    }
}

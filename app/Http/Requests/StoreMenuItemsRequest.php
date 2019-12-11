<?php

namespace App\Http\Requests;

/**
 * Request object for storing menu items.
 *
 * @package App\Http\Requests
 */
class StoreMenuItemsRequest extends AbstractStoreItemRequest
{
    /**
     * @inheritDoc
     */
    protected function getMenuId(): ?int
    {
        return $this->route()->parameter('id');
    }
}

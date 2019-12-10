<?php

namespace App\Http\Requests;

/**
 * Request object for storing item children.
 *
 * @package App\Http\Requests
 */
class StoreItemChildrenRequest extends AbstractStoreItemRequest
{
    /**
     * @inheritDoc
     */
    protected function getMenuId(): ?int
    {
        return null;
    }
}

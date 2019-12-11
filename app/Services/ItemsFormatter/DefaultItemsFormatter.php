<?php

namespace App\Services\ItemsFormatter;

use App\Item;
use Illuminate\Database\Eloquent\Collection;

/**
 * Implementation of the items formatter. Probably could have been done better using nested sets, but let's stick
 * with a working implementation for now.
 *
 * @package App\Services\ItemsFormatter
 */
class DefaultItemsFormatter implements ItemsFormatter
{
    /**
     * @inheritDoc
     */
    public function toNestedArray(Collection $items, ?int $parentId = null): array
    {
        $level = [];

        foreach ($items as $item) {
            if ($item->parent_id === $parentId) {
                $itemArray = $item->toArray();
                $children = $this->toNestedArray($items, $item->id);

                if (count($children)) {
                    $itemArray['children'] = $children;
                }

                $level[] = $itemArray;
            }
        }

        return $level;
    }

    /**
     * @inheritDoc
     */
    public function itemToNestedArray(Item $item): array
    {
        $children = [];

        foreach ($item->children as $child) {
            $children[] = $this->itemToNestedArray($child);
        }

        $item = $item->toArray();

        if (count($children)) {
            $item['children'] = $children;
        }

        return $item;
    }
}

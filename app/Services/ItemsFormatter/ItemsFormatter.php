<?php

namespace App\Services\ItemsFormatter;

use Illuminate\Database\Eloquent\Collection;

/**
 * Formats items of the menu.
 *
 * @package App\Services\ItemsFormatter
 */
interface ItemsFormatter
{
    /**
     * Returns a nested array of items in the format specified by the task docs.
     *
     * @param Collection $items
     * @param int|null $parentId
     * @return array
     */
    public function toNestedArray(Collection $items, ?int $parentId = null): array;
}

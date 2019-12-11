<?php

namespace App\Services\MenuRegistry;

use App\Http\Requests\StoreItemChildrenRequest;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\StoreMenuItemsRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Item;
use App\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

/**
 * Eloquent implementation of the registry.
 *
 * @package App\Services\MenuRegistry
 * @todo Use transactions where needed.
 */
class SimpleEloquentMenuRegistry implements MenuRegistry
{
    /**
     * @inheritDoc
     */
    public function storeMenu(StoreMenuRequest $request): Menu
    {
        return Menu::create($request->validated());
    }

    /**
     * @inheritDoc
     */
    public function findMenuById(int $id, bool $withItems = false): Menu
    {
        return $withItems ? Menu::with('items')->findOrFail($id): Menu::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function updateMenu(int $id, UpdateMenuRequest $request): Menu
    {
        $menu = $this->findMenuById($id);
        $this->updateEntity($menu, $request);

        return $menu;
    }

    /**
     * @inheritDoc
     */
    public function deleteMenu(int $id): void
    {
        $menu = $this->findMenuById($id);
        $menu->delete();
    }

    /**
     * @inheritDoc
     */
    public function storeMenuItems(int $id, StoreMenuItemsRequest $request): void
    {
        $menu = $this->findMenuById($id);
        $menu->items()->delete();
        $this->storeItems($request->validated()['data'], $menu);
    }

    /**
     * @inheritDoc
     */
    public function deleteMenuItems(int $id): void
    {
        $menu = $this->findMenuById($id);
        $menu->items()->delete();
    }

    /**
     * Recursive method used to store menu items in the database.
     *
     * @param array $items
     * @param Menu|null $menu
     * @param Item|null $parent
     */
    private function storeItems(array $items, ?Menu $menu = null, ?Item $parent = null)
    {
        foreach ($items as $itemData) {
            $item = new Item();
            $item->field = $itemData['field'];

            if (null !== $menu) {
                $item->menu()->associate($menu);
            }

            if ($parent) {
                $item->parent()->associate($parent);
            }

            $item->save();

            if (!empty($itemData['children'])) {
                $this->storeItems($itemData['children'], $menu, $item);
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function storeSingleItem(StoreItemRequest $request): Item
    {
        return Item::create($request->validated());
    }

    /**
     * @inheritDoc
     */
    public function findItemById(int $id): Item
    {
        return Item::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function updateItem(int $id, UpdateItemRequest $request): Item
    {
        $item = $this->findItemById($id);
        $this->updateEntity($item, $request);

        return $item;
    }

    /**
     * @inheritDoc
     */
    public function deleteItem(int $id): void
    {
        $item = $this->findItemById($id);
        $this->deleteItemChildren($item);
        $item->delete();
    }

    /**
     * @inheritDoc
     */
    public function storeItemChildren(int $id, StoreItemChildrenRequest $request): void
    {
        $item = $this->findItemById($id);
        $this->deleteItemChildren($item);
        $this->storeItems($request->validated()['data'], null, $item);
    }

    /**
     * @inheritDoc
     */
    public function deleteItemChildren(Item $item): void
    {
        foreach ($item->children as $child) {
            $this->deleteItemChildren($child);
            $child->delete();
        }
    }

    /**
     * @inheritDoc
     */
    public function getMenuLayer(int $id, int $layer): array
    {
        $menu = $this->findMenuById($id);
        $items = $menu->items()
            ->where('parent_id', null)
            ->get()
            ->all();

        if (empty($items)) {
            return [];
        }

        // Using convention that the first layer is numbered 1 instead of 0, for readability
        for ($i = 2; $i <= $layer; ++$i) {
            $childItems = [];

            foreach ($items as $item) {
                $childItems = array_merge($childItems, $item->children->all());
            }

            $items = $childItems;

            // Break the loop if no items remaining, no need to search further
            if (empty($items)) {
                break;
            }
        }

        return $items;
    }

    /**
     * Helper function for updating model fields.
     *
     * @param Model $entity
     * @param FormRequest $request
     */
    private function updateEntity(Model $entity, FormRequest $request): void
    {
        foreach ($request->validated() as $name => $value) {
            $entity->$name = $value;
        }

        $entity->save();
    }
}

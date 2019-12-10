<?php

namespace App\Services\MenuRegistry;

use App\Http\Requests\StoreMenuItemsRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Item;
use App\Menu;

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
    public function findById(int $id, bool $withItems = false): Menu
    {
        return $withItems ? Menu::with('items')->findOrFail($id): Menu::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function updateMenu(int $id, UpdateMenuRequest $request): Menu
    {
        $menu = $this->findById($id);

        foreach ($request->validated() as $name => $value) {
            $menu->$name = $value;
        }

        $menu->save();

        return $menu;
    }

    /**
     * @inheritDoc
     */
    public function deleteMenu(int $id): void
    {
        $menu = $this->findById($id);
        $menu->delete();
    }

    /**
     * @inheritDoc
     */
    public function storeMenuItems(int $id, StoreMenuItemsRequest $request): void
    {
        $menu = $this->findById($id);
        $menu->items()->delete();
        $this->storeItems($request->validated()['data'], $menu);
    }

    /**
     * Recursive method used to store menu items in the database.
     *
     * @param array $items
     * @param Menu $menu
     * @param Item|null $parent
     */
    private function storeItems(array $items, Menu $menu, ?Item $parent = null)
    {
        foreach ($items as $itemData) {
            $item = new Item();
            $item->field = $itemData['field'];
            $item->menu()->associate($menu);

            if ($parent) {
                $item->parent()->associate($parent);
            }

            $item->save();

            if (!empty($itemData['children'])) {
                $this->storeItems($itemData['children'], $menu, $item);
            }
        }
    }
}

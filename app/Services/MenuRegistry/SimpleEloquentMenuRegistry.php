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

        return $this->traverseMenu($menu, $layer)[0];
    }

    /**
     * @inheritDoc
     */
    public function deleteMenuLayer(int $id, int $layer): void
    {
        $items = $this->getMenuLayer($id, $layer);

        /* @var Item $item */
        foreach ($items as $item) {
            /* @var Item $child */
            foreach ($item->children as $child) {
                $child->parent()->associate($item->parent);
                $child->save();
            }

            $item->delete();
        }
    }

    /**
     * @inheritDoc
     */
    public function getMenuDepth(int $id): int
    {
        $menu = $this->findMenuById($id);

        return $this->traverseMenu($menu)[1];
    }

    /**
     * Helper function for traversing menu tree. If layer is specified, returns the items on the layer and its number.
     * Otherwise it traverses to the end and returns the number of the last layer (menu depth).
     *
     * @param Menu $menu
     * @param int|null $layer
     * @return array
     */
    private function traverseMenu(Menu $menu, ?int $layer = null): array
    {
        $items = $menu->items()
            ->where('parent_id', null)
            ->get()
            ->all();

        if (empty($items)) {
            return [[], 0];
        }

        if (1 === $layer) {
            return [$items, $layer];
        }

        $currentDepth = 1;

        do {
            ++$currentDepth;
            $childItems = [];

            foreach ($items as $item) {
                $childItems = array_merge($childItems, $item->children->all());
            }

            $items = $childItems;
        } while (count($items) && (null === $layer || $layer > $currentDepth));

        return [$items, $currentDepth - 1];
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

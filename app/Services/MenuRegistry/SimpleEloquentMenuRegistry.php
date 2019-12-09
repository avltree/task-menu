<?php

namespace App\Services\MenuRegistry;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
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
    public function findById(int $id): Menu
    {
        return Menu::findOrFail($id);
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
}

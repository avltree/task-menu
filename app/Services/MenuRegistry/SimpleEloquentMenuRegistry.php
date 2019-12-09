<?php

namespace App\Services\MenuRegistry;

use App\Http\Requests\StoreMenuRequest;
use App\Menu;

class SimpleEloquentMenuRegistry implements MenuRegistry
{
    public function storeMenu(StoreMenuRequest $request): Menu
    {
        return Menu::create($request->validated());
    }

    public function findById(int $id): Menu
    {
        return Menu::findOrFail($id);
    }
}

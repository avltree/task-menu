<?php

namespace App\Services\MenuRegistry;

use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Menu;

interface MenuRegistry
{
    public function storeMenu(StoreMenuRequest $request): Menu;

    public function findById(int $id): ?Menu;

    public function updateMenu(int $id, UpdateMenuRequest $request): Menu;

    public function deleteMenu(int $id): void;
}

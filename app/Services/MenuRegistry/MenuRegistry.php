<?php

namespace App\Services\MenuRegistry;

use App\Http\Requests\StoreMenuRequest;
use App\Menu;

interface MenuRegistry
{
    public function storeMenu(StoreMenuRequest $request): Menu;
}

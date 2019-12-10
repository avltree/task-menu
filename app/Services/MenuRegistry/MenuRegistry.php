<?php

namespace App\Services\MenuRegistry;

use App\Http\Requests\StoreMenuItemsRequest;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Menu;

/**
 * Interface for services designed to store the menus and their items.
 *
 * @package App\Services\MenuRegistry
 */
interface MenuRegistry
{
    /**
     * Stores a new menu.
     *
     * @param StoreMenuRequest $request
     * @return Menu
     */
    public function storeMenu(StoreMenuRequest $request): Menu;

    /**
     * Finds a menu by its id.
     *
     * @param int $id
     * @param bool $withItems
     * @return Menu
     */
    public function findById(int $id, bool $withItems = false): Menu;

    /**
     * Updates a menu.
     *
     * @param int $id
     * @param UpdateMenuRequest $request
     * @return Menu
     */
    public function updateMenu(int $id, UpdateMenuRequest $request): Menu;

    /**
     * Deletes a menu.
     *
     * @param int $id
     */
    public function deleteMenu(int $id): void;

    /**
     * Stores items for a specified menu. Overwrites the existing items.
     *
     * @param int $id
     * @param StoreMenuItemsRequest $request
     */
    public function storeMenuItems(int $id, StoreMenuItemsRequest $request): void;
}

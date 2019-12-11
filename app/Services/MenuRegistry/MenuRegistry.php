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
    public function findMenuById(int $id, bool $withItems = false): Menu;

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

    /**
     * Deletes all of the menu's items.
     *
     * @param int $id
     */
    public function deleteMenuItems(int $id): void;

    /**
     * Stores a single item.
     *
     * @param StoreItemRequest $request
     * @return Item
     */
    public function storeSingleItem(StoreItemRequest $request): Item;

    /**
     * Finds a single item in the database.
     *
     * @param int $id
     * @return Item
     */
    public function findItemById(int $id): Item;

    /**
     * Updates a single item.
     *
     * @param int $id
     * @param UpdateItemRequest $request
     * @return Item
     */
    public function updateItem(int $id, UpdateItemRequest $request): Item;

    /**
     * Deletes an item.
     *
     * @param int $id
     */
    public function deleteItem(int $id): void;

    /**
     * Stores child items for a specified item. Overwrites the existing items.
     *
     * @param int $id
     * @param StoreItemChildrenRequest $request
     */
    public function storeItemChildren(int $id, StoreItemChildrenRequest $request): void;

    /**
     * Deletes all of the item's children.
     *
     * @param Item $item
     */
    public function deleteItemChildren(Item $item): void;
}

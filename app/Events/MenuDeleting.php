<?php

namespace App\Events;

use App\Menu;

/**
 * Event dispatched when a menu is deleted.
 *
 * @package App\Events
 */
class MenuDeleting
{
    /**
     * @var Menu
     */
    private $menu;

    /**
     * MenuDeleted constructor.
     *
     * @param Menu $menu
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return Menu
     */
    public function getMenu(): Menu
    {
        return $this->menu;
    }
}

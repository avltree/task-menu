<?php

namespace App\Listeners;

use App\Events\MenuDeleting;

/**
 * Listens to an event dispatched when a menu is deleted. Used to delete menu items belonging to that menu.
 *
 * @package App\Listeners
 */
class MenuDeletingListener
{
    /**
     * Handles the event.
     *
     * @param MenuDeleting $event
     */
    public function handle(MenuDeleting $event): void
    {
        $event->getMenu()->items()->delete();
    }
}

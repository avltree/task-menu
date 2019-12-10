<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuItemsRequest;
use App\Services\MenuRegistry\MenuRegistry;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * @var MenuRegistry
     */
    protected $menuRegistry;

    /**
     * MenuController constructor.
     *
     * @param MenuRegistry $menuRegistry
     */
    public function __construct(MenuRegistry $menuRegistry)
    {
        $this->menuRegistry = $menuRegistry;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMenuItemsRequest $request
     * @param int $id
     */
    public function store(StoreMenuItemsRequest $request, int $id)
    {
        $this->menuRegistry->storeMenuItems($id, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        //
    }
}

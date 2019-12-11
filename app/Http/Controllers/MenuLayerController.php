<?php

namespace App\Http\Controllers;

use App\Services\MenuRegistry\MenuRegistry;

class MenuLayerController extends Controller
{
    /**
     * @var MenuRegistry
     */
    private $menuRegistry;

    /**
     * MenuLayerController constructor.
     *
     * @param MenuRegistry $menuRegistry
     */
    public function __construct(MenuRegistry $menuRegistry)
    {
        $this->menuRegistry = $menuRegistry;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param int $layer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id, int $layer)
    {
        return response()->json($this->menuRegistry->getMenuLayer($id, $layer));
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

<?php

namespace App\Http\Controllers;

use App\Services\MenuRegistry\MenuRegistry;

class MenuDepthController extends Controller
{
    /**
     * @var MenuRegistry
     */
    private $menuRegistry;

    /**
     * MenuDepthController constructor.
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json([
            'depth' => $this->menuRegistry->getMenuDepth($id)
        ]);
    }
}

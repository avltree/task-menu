<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuRequest;
use App\Services\MenuRegistry\MenuRegistry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller
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
     * @param StoreMenuRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMenuRequest $request)
    {
        $menu = $this->menuRegistry->storeMenu($request);

        return response()->json($menu)
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json($this->menuRegistry->findById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menu)
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

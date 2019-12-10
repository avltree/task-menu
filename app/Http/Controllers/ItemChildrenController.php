<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemChildrenRequest;
use App\Services\MenuRegistry\MenuRegistry;
use Illuminate\Http\Request;

class ItemChildrenController extends Controller
{
    /**
     * @var MenuRegistry
     */
    private $menuRegistry;

    /**
     * ItemChildrenController constructor.
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemChildrenRequest $request, int $id)
    {
        $this->menuRegistry->storeItemChildren($id, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $item
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\MenuRegistry\MenuRegistry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    /**
     * @var MenuRegistry
     */
    protected $menuRegistry;

    /**
     * ItemController constructor.
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
     * @param StoreItemRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreItemRequest $request)
    {
        return response()->json($this->menuRegistry->storeSingleItem($request))
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
        return response()->json($this->menuRegistry->findItemById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateItemRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateItemRequest $request, int $id)
    {
        return response()->json($this->menuRegistry->updateItem($id, $request));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->menuRegistry->deleteItem($id);

        return response()->noContent();
    }
}

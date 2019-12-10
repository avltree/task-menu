<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuItemsRequest;
use App\Services\ItemsFormatter\ItemsFormatter;
use App\Services\MenuRegistry\MenuRegistry;
use Illuminate\Http\Response;

class MenuItemController extends Controller
{
    /**
     * @var MenuRegistry
     */
    protected $menuRegistry;

    /**
     * @var ItemsFormatter
     */
    protected $itemsFormatter;

    /**
     * MenuController constructor.
     *
     * @param MenuRegistry $menuRegistry
     * @param ItemsFormatter $itemsFormatter
     */
    public function __construct(MenuRegistry $menuRegistry, ItemsFormatter $itemsFormatter)
    {
        $this->menuRegistry = $menuRegistry;
        $this->itemsFormatter = $itemsFormatter;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMenuItemsRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMenuItemsRequest $request, int $id)
    {
        $this->menuRegistry->storeMenuItems($id, $request);

        return $this->show($id)->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json(
            $this->itemsFormatter
                ->toNestedArray($this->menuRegistry->findMenuById($id, true)->items)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->menuRegistry->deleteMenuItems($id);

        return response()->noContent();
    }
}

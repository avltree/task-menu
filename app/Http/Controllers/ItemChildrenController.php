<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemChildrenRequest;
use App\Services\ItemsFormatter\ItemsFormatter;
use App\Services\MenuRegistry\MenuRegistry;
use Illuminate\Http\Response;

class ItemChildrenController extends Controller
{
    /**
     * @var MenuRegistry
     */
    private $menuRegistry;

    /**
     * @var ItemsFormatter
     */
    private $itemsFormatter;

    /**
     * ItemChildrenController constructor.
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
     * @param StoreItemChildrenRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreItemChildrenRequest $request, int $id)
    {
        $this->menuRegistry->storeItemChildren($id, $request);

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
        $item = $this->menuRegistry->findItemById($id);
        $array = $this->itemsFormatter->itemToNestedArray($item);

        return response()->json(empty($array['children']) ? [] : $array['children']);
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

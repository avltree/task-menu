<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ItemChildrenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test storing an item's children.
     */
    public function testStoreItemChildren()
    {
        $itemsData = [
            [
                'field' => 'value',
                'children' => [
                    [
                        'field' => 'value'
                    ]
                ]
            ],
            [
                'field' => 'value'
            ]
        ];
        $uri = sprintf('/api/items/%d/children', $this->createItem());
        $storeResponse = $this->postJson($uri, $itemsData);
        $getResponse = $this->get($uri);

        $storeResponse->assertStatus(Response::HTTP_CREATED);
        $storeResponse->assertJson($itemsData);
        $getResponse->assertStatus(Response::HTTP_OK);
        $getResponse->assertJson($itemsData);
    }

    /**
     * Creates a menu with specified max depth and children count by HTTP request.
     *
     * @return int
     */
    private function createItem(): int
    {
        $menuData = [
            'field' => 'value'
        ];
        $response = $this->postJson('/api/items', $menuData);

        return $response->json('id');
    }
}

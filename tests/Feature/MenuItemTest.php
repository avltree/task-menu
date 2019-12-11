<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class MenuItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests posting proper data.
     */
    public function testStoreMenuItems()
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
        $response = $this->postJson(sprintf('/api/menus/%d/items', $this->createMenu(2, 2)), $itemsData);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson($itemsData);
    }

    /**
     * Tests posting the resource using a not existing menu.
     */
    public function testNotExistingMenu()
    {
        // Let's make sure we have an id which really does not exist by explicitly deleting it
        $id = $this->createMenu(1, 1);
        $this->delete('/api/menus/' . $id);
        $uri = sprintf('/api/menus/%d/items', $id);
        $postResponse = $this->postJson($uri, []);
        $showResponse = $this->get($uri);
        $deleteResponse = $this->delete($uri);

        $postResponse->assertStatus(Response::HTTP_NOT_FOUND);
        $showResponse->assertStatus(Response::HTTP_NOT_FOUND);
        $deleteResponse->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Tests the checking of max depth and children on the menu.
     */
    public function testExceededParams()
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
        $response = $this->postJson(sprintf('/api/menus/%d/items', $this->createMenu(1, 1)), $itemsData);
        $response->assertExactJson([
            'items' => [
                'Items length is 2, but max is 1.',
                'The items depth is 2, but max is 1.'
            ]
        ]);
    }

    /**
     * Test deleting of menu items.
     */
    public function testDeleteItems()
    {
        $id = $this->createMenu(1, 1);
        $uri = sprintf('/api/menus/%d/items', $id);
        $itemsData = [
            [
                'field' => 'value'
            ]
        ];
        $this->postJson($uri, $itemsData);
        $deleteResponse = $this->delete($uri);
        $showResponse = $this->get($uri);

        $deleteResponse->assertStatus(Response::HTTP_NO_CONTENT);
        $showResponse->assertExactJson([]);
        $showResponse->assertStatus(Response::HTTP_OK);
    }

    /**
     * Creates a menu with specified max depth and children count by HTTP request.
     *
     * @param int $maxDepth
     * @param int $maxChildren
     * @return int
     */
    private function createMenu(int $maxDepth, int $maxChildren): int
    {
        $menuData = [
            'field' => 'value',
            'max_depth' => $maxDepth,
            'max_children' => $maxChildren
        ];
        $response = $this->postJson('/api/menus', $menuData);

        return $response->json('id');
    }
}

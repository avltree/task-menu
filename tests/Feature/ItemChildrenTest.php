<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ItemChildrenTest extends TestCase
{
    use RefreshDatabase;

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
        $response = $this->postJson(sprintf('/api/items/%d/children', $this->createItem()), $itemsData);

        $response->assertStatus(Response::HTTP_CREATED);
        // TODO checking return data
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

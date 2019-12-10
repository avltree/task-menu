<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test storing single item.
     */
    public function testStoreItem()
    {
        $itemData = [
            'field' => 'value'
        ];
        $response = $this->postJson('/api/items', $itemData);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson($itemData);
    }

    /**
     * Test item update.
     */
    public function testUpdateItem()
    {
        $itemData = [
            'field' => 'value'
        ];
        $storeResponse = $this->postJson('/api/items', $itemData);
        $newItemData = [
            'field' => 'new_value'
        ];
        $response = $this->put('/api/items/' . $storeResponse->json('id'), $newItemData);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($newItemData);
    }
}

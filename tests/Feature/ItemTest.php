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

    /**
     * Tests deleting an item and also getting a nonexistent item.
     */
    public function testDeleteAndNotFound()
    {
        $itemData = [
            'field' => 'value'
        ];
        $storeResponse = $this->postJson('/api/items', $itemData);
        $uri = '/api/items/' . $storeResponse->json('id');
        $deleteResponse = $this->delete($uri);
        $findResponse = $this->get($uri);

        $deleteResponse->assertStatus(Response::HTTP_NO_CONTENT);
        $findResponse->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Test deleting an item with children.
     */
    public function testDeleteItemWithChildren()
    {
        $itemData = [
            'field' => 'value'
        ];
        $storeResponse = $this->postJson('/api/items', $itemData);
        $itemId = $storeResponse->json('id');
        $itemsData = [
            [
                'field' => 'value'
            ]
        ];
        $this->postJson(sprintf('/api/items/%d/items', $itemId), $itemsData);
        $deleteResponse = $this->delete('/api/items/' . $itemId);

        $deleteResponse->assertStatus(Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test storing the menu.
     */
    public function testStoreMenu()
    {
        $menuData = [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 5
        ];
        $response = $this->postJson('/api/menus', $menuData);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson($menuData);
    }

    /**
     * Test storing a menu with invalid params.
     */
    public function testStoreInvalidMenu()
    {
        $menuData = [
            'field' => 'value',
            'max_depth' => -5,
            'max_children' => 500000
        ];
        $response = $this->postJson('/api/menus', $menuData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertExactJson([
            'max_depth' => ['The max depth must be at least 1.'],
            'max_children' => ['The max children may not be greater than 32767.']
        ]);
    }

    /**
     * Test trying to store a duplicate menu (the same 'field' value).
     */
    public function testStoreDuplicateMenu()
    {
        $menuData = [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 5
        ];
        $this->postJson('/api/menus', $menuData);
        $response = $this->postJson('/api/menus', $menuData);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertExactJson([
            'field' => ['The field has already been taken.']
        ]);
    }

    /**
     * Test getting a single menu.
     */
    public function testShow()
    {
        $menuData = [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 5
        ];
        $storeResponse = $this->postJson('/api/menus', $menuData);
        $response = $this->get('/api/menus/' . $storeResponse->json('id'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($menuData);
    }

    /**
     * Test updating a menu.
     */
    public function testUpdate()
    {
        $menuData = [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 5
        ];
        $storeResponse = $this->postJson('/api/menus', $menuData);
        $newMenuData = [
            'field' => 'new_value',
            'max_depth' => 15,
            'max_children' => 25
        ];
        $response = $this->put('/api/menus/' . $storeResponse->json('id'), $newMenuData);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson($newMenuData);
    }

    /**
     * Test an empty menu update.
     */
    public function testEmptyUpdate()
    {
        $menuData = [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 5
        ];
        $storeResponse = $this->postJson('/api/menus', $menuData);
        $response = $this->put('/api/menus/' . $storeResponse->json('id'), []);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertExactJson([
            'field' => ['Nothing to update.']
        ]);
    }

    /**
     * Tests deleting a menu and also getting a nonexistent menu item.
     */
    public function testDeleteAndNotFound()
    {
        $menuData = [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 5
        ];
        $storeResponse = $this->postJson('/api/menus', $menuData);
        $deleteResponse = $this->delete('/api/menus/' . $storeResponse->json('id'));
        $findResponse = $this->get('/api/menus/' . $storeResponse->json('id'));

        $deleteResponse->assertStatus(Response::HTTP_NO_CONTENT);
        $findResponse->assertStatus(Response::HTTP_NOT_FOUND);
    }
}

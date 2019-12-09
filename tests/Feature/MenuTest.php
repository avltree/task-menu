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
     *
     * @return void
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
}

<?php 

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_create_category()
    {
        $response = $this->postJson('/api/categories', [
            'name' => 'Biochemia'
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['name' => 'Biochemia']);

        $this->assertDatabaseHas('categories', ['name' => 'Biochemia']);
    }

    public function test_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
        ]);
    }
}

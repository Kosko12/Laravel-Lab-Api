<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_can_create_product_with_categories_and_delivery_days()
    {
        $categories = Category::factory()->count(2)->create();

        $payload = [
            'name' => 'Badanie krwi',
            'price' => 99.99,
            'delivery_days' => 2,
            'category_ids' => $categories->pluck('id')->toArray()
        ];

        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'name' => 'Badanie krwi',
                     'delivery_days' => 2
                 ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Badanie krwi',
            'delivery_days' => 2
        ]);
    }

    public function test_can_show_single_product()
    {
        $product = Product::factory()->create([
            'delivery_days' => 3
        ]);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => $product->name,
                     'delivery_days' => 3
                 ]);
    }

    public function test_can_update_product_with_delivery_days()
    {
        $product = Product::factory()->create([
            'name' => 'Stare badanie',
            'delivery_days' => 4
        ]);

        $newCategory = Category::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Nowe badanie',
            'price' => 199.00,
            'delivery_days' => 1,
            'category_ids' => [$newCategory->id]
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => 'Nowe badanie',
                     'delivery_days' => 1
                 ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Nowe badanie',
            'delivery_days' => 1
        ]);
    }

    public function test_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }

    public function test_validation_error_when_delivery_days_missing()
    {
        $response = $this->postJson('/api/products', [
            'name' => 'Badanie bez dni',
            'price' => 45.00
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['delivery_days']);
    }
}

<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_product()
    {
        $product = Product::factory()->create();

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
        ]);
    }

    /** @test */
    public function it_has_categories()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();

        // Łączymy produkt z kategorią
        $product->categories()->attach($category);

        // Sprawdzamy, czy produkt ma przypisaną kategorię
        $this->assertTrue($product->categories->contains($category));
    }
}

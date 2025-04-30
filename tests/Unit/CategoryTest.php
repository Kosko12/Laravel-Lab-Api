<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_creates_a_category()
    {
        $category = Category::factory()->create();

        $this->assertDatabaseHas('categories', [
            'name' => $category->name,
        ]);
    }

    /** @test */
    public function it_has_products()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();

        $category->products()->attach($product);

        $this->assertTrue($category->products->contains($product));
    
    }
}

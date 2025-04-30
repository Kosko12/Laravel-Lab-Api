<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsSeederTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_seeds_products_and_categories()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $this->assertDatabaseHas('products', [
            'name' => 'Badanie poziomu glukozy',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Morfologia krwi',
        ]);

        $product = Product::where('name', 'Badanie poziomu glukozy')->first();
        $category = Category::where('name', 'Biochemia')->first();

        $this->assertTrue($product->categories->contains($category));
    }
}

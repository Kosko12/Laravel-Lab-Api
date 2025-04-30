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
            'name' => 'e-Pakiet Zdrowie Ogólne',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'e-Pakiet Alergia Mieszana',
        ]);

        $product = Product::where('name', 'e-Pakiet Diagnostyka Metaboliczna')->first();
        $category = Category::where('name', 'Profilaktyka')->first();

        $this->assertTrue($product->categories->contains($category));
    }
}

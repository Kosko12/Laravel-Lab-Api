<?php

namespace Tests\Feature;

use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesSeederTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_seeds_categories()
    {
        $this->seed(CategorySeeder::class);
        
        $this->assertDatabaseHas('categories', [
            'name' => 'Biochemia',
        ]);
        $this->assertDatabaseHas('categories', [
            'name' => 'Hematologia',
        ]);
    }
}

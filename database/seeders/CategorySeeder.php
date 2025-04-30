<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Tworzymy kilka kategorii za pomocą fabryki
        Category::factory()->create([
            'name' => 'Biochemia',
        ]);
        
        Category::factory()->create([
            'name' => 'Hematologia',
        ]);
        
        Category::factory()->create([
            'name' => 'Diagnostyka ogólna',
        ]);
        
        Category::factory()->create([
            'name' => 'Mikrobiologia',
        ]);
        
        Category::factory()->create([
            'name' => 'Genetyka',
        ]);
    }
}

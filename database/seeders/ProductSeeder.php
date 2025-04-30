<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tworzymy kilka produktów za pomocą fabryki
        Product::factory()->create([
            'name' => 'Badanie poziomu glukozy',
            'description' => 'Badanie poziomu glukozy we krwi',
            'price' => 50.00,
            'delivery_days' => 2,
            'active' => true,
        ])->categories()->attach([
            Category::where('name', 'Biochemia')->first()->id,
            Category::where('name', 'Diagnostyka ogólna')->first()->id,
        ]);

        Product::factory()->create([
            'name' => 'Morfologia krwi',
            'description' => 'Badanie krwi oceniające ogólny stan zdrowia',
            'price' => 40.00,
            'delivery_days' => 3,
            'active' => true,
        ])->categories()->attach([
            Category::where('name', 'Hematologia')->first()->id,
        ]);

        Product::factory()->create([
            'name' => 'Badanie genetyczne',
            'description' => 'Badanie w kierunku chorób genetycznych',
            'price' => 200.00,
            'delivery_days' => 5,
            'active' => true,
        ])->categories()->attach([
            Category::where('name', 'Genetyka')->first()->id,
        ]);

        Product::factory()->create([
            'name' => 'Badanie bakteriologiczne',
            'description' => 'Badanie w kierunku bakterii patogennych',
            'price' => 75.00,
            'delivery_days' => 3,
            'active' => true,
        ])->categories()->attach([
            Category::where('name', 'Mikrobiologia')->first()->id,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Profilaktyka',
            'Dla kobiet',
            'Dla mężczyzn',
            'Nietolerancje i alergie',
            'Hormony',
            'Odpornościowe',
            'Układ pokarmowy',
            'Układ krążenia',
            'Układ moczowy',
            'Układ oddechowy',
            'Choroby zakaźne',
            'Trzustka i wątroba',
            'Alergie'
        ];

        foreach ($categories as $name) {
            Category::factory()->create([
                'name' => $name
            ]);
        }
    }
}

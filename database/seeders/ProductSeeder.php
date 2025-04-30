<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Profilaktyka' => [
                ['name' => 'e-Pakiet Zdrowie Ogólne', 'price' => 249.00, 'delivery_days' => 2],
                ['name' => 'e-Pakiet Diagnostyka Metaboliczna', 'price' => 199.00, 'delivery_days' => 3],
                ['name' => 'e-Pakiet Przeglądowy dla Dorosłych', 'price' => 299.00, 'delivery_days' => 2],
            ],
            'Dla kobiet' => [
                ['name' => 'e-Pakiet Hormony Kobiece', 'price' => 159.00, 'delivery_days' => 4],
                ['name' => 'e-Pakiet Zdrowie Intymne', 'price' => 179.00, 'delivery_days' => 3],
                ['name' => 'e-Pakiet Ciąża i Płodność', 'price' => 219.00, 'delivery_days' => 5],
            ],
            'Dla mężczyzn' => [
                ['name' => 'e-Pakiet Testosteron i Prostata', 'price' => 189.00, 'delivery_days' => 3],
                ['name' => 'e-Pakiet Kondycja Fizyczna', 'price' => 169.00, 'delivery_days' => 2],
                ['name' => 'e-Pakiet Zdrowie Mężczyzny 40+', 'price' => 259.00, 'delivery_days' => 4],
            ],
            'Odpornościowe' => [
                ['name' => 'e-Pakiet Układ Odpornościowy', 'price' => 149.00, 'delivery_days' => 3],
                ['name' => 'e-Pakiet Autoimmunologia', 'price' => 199.00, 'delivery_days' => 4],
                ['name' => 'e-Pakiet Immunoglobuliny', 'price' => 129.00, 'delivery_days' => 2],
            ],
            'Trzustka i wątroba' => [
                ['name' => 'e-Pakiet Wątroba i Drogi Żółciowe', 'price' => 179.00, 'delivery_days' => 3],
                ['name' => 'e-Pakiet Trzustka - Podstawowy', 'price' => 159.00, 'delivery_days' => 3],
                ['name' => 'e-Pakiet Enzymy Wątrobowe', 'price' => 189.00, 'delivery_days' => 2],
            ],
            'Alergie' => [
                ['name' => 'e-Pakiet Pokarmowe Alergeny', 'price' => 299.00, 'delivery_days' => 5],
                ['name' => 'e-Pakiet Wziewne Alergeny', 'price' => 279.00, 'delivery_days' => 5],
                ['name' => 'e-Pakiet Alergia Mieszana', 'price' => 319.00, 'delivery_days' => 6],
            ],
        ];

        foreach ($data as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->first();

            if (!$category) {
                continue;
            }

            foreach ($products as $product) {
                $newProduct = Product::factory()->create([
                    'name' => $product['name'],
                    'description' => 'Opis dla badania: ' . $product['name'],
                    'price' => $product['price'],
                    'delivery_days' => $product['delivery_days'],
                ]);

                $newProduct->categories()->sync($category['id'] ?? []);

            }
            
        }
    }
}

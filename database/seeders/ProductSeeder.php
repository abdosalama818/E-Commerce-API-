<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
    {
        $fakerEn = Factory::create('en_US'); // English
        $fakerAr = Factory::create('ar_SA'); // Arabic

        for ($i = 1; $i <= 10000; $i++) {
            $product = Product::create([
                'title' => [
                    'en' => $fakerEn->words(3, true),
                    'ar' => $fakerAr->words(3, true),
                ],
                'slug' => $fakerEn->slug,
                'description' => [
                    'en' => $fakerEn->sentence(10),
                    'ar' => $fakerAr->sentence(10),
                ],
                'price' => $fakerEn->randomFloat(2, 10, 500),
                'quantity' => $fakerEn->numberBetween(1, 100),
            ]);

       
            $imagePath = 'https://picsum.photos/300/300?random=' . rand(1, 500); 
           $product->addMediaFromUrl($imagePath)->toMediaCollection('images');

        }
    }
}

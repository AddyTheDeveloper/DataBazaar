<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Grains & Cereals',
            'Vegetables',
            'Fruits',
            'Dairy Products',
            'Meat & Poultry',
            'Spices & Herbs',
            'Beverages',
            'Electronics',
            'Textiles & Clothing',
            'Others',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}

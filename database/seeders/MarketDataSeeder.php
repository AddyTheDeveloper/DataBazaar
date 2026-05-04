<?php

namespace Database\Seeders;

use App\Models\MarketData;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MarketDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $categories = Category::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            return;
        }

        $products = [
            'Grains & Cereals' => [
                ['name' => 'Basmati Rice', 'min' => 45, 'max' => 120],
                ['name' => 'Wheat Flour', 'min' => 25, 'max' => 55],
                ['name' => 'Corn', 'min' => 20, 'max' => 45],
                ['name' => 'Oats', 'min' => 80, 'max' => 200],
                ['name' => 'Quinoa', 'min' => 300, 'max' => 600],
            ],
            'Vegetables' => [
                ['name' => 'Tomatoes', 'min' => 15, 'max' => 80],
                ['name' => 'Onions', 'min' => 20, 'max' => 60],
                ['name' => 'Potatoes', 'min' => 15, 'max' => 40],
                ['name' => 'Green Peppers', 'min' => 30, 'max' => 100],
                ['name' => 'Carrots', 'min' => 25, 'max' => 60],
            ],
            'Fruits' => [
                ['name' => 'Apples', 'min' => 80, 'max' => 200],
                ['name' => 'Bananas', 'min' => 30, 'max' => 70],
                ['name' => 'Mangoes', 'min' => 50, 'max' => 150],
                ['name' => 'Oranges', 'min' => 40, 'max' => 100],
                ['name' => 'Grapes', 'min' => 60, 'max' => 180],
            ],
            'Dairy Products' => [
                ['name' => 'Fresh Milk (1L)', 'min' => 50, 'max' => 80],
                ['name' => 'Paneer (1kg)', 'min' => 250, 'max' => 400],
                ['name' => 'Butter (500g)', 'min' => 200, 'max' => 350],
                ['name' => 'Curd (1kg)', 'min' => 40, 'max' => 80],
            ],
            'Meat & Poultry' => [
                ['name' => 'Chicken (1kg)', 'min' => 150, 'max' => 300],
                ['name' => 'Mutton (1kg)', 'min' => 500, 'max' => 900],
                ['name' => 'Eggs (dozen)', 'min' => 60, 'max' => 120],
                ['name' => 'Fish (1kg)', 'min' => 200, 'max' => 500],
            ],
            'Spices & Herbs' => [
                ['name' => 'Turmeric (100g)', 'min' => 30, 'max' => 80],
                ['name' => 'Red Chili Powder (100g)', 'min' => 40, 'max' => 100],
                ['name' => 'Black Pepper (100g)', 'min' => 80, 'max' => 200],
                ['name' => 'Cumin Seeds (100g)', 'min' => 50, 'max' => 120],
            ],
            'Beverages' => [
                ['name' => 'Tea Leaves (250g)', 'min' => 100, 'max' => 300],
                ['name' => 'Coffee Beans (250g)', 'min' => 200, 'max' => 500],
                ['name' => 'Orange Juice (1L)', 'min' => 80, 'max' => 150],
            ],
            'Electronics' => [
                ['name' => 'USB Cable', 'min' => 100, 'max' => 500],
                ['name' => 'LED Bulb', 'min' => 50, 'max' => 200],
                ['name' => 'Power Bank', 'min' => 500, 'max' => 2000],
            ],
            'Textiles & Clothing' => [
                ['name' => 'Cotton Fabric (1m)', 'min' => 100, 'max' => 400],
                ['name' => 'Silk Fabric (1m)', 'min' => 300, 'max' => 1500],
            ],
        ];

        $locations = [
            'Mumbai', 'Delhi', 'Bangalore', 'Chennai', 'Kolkata',
            'Hyderabad', 'Pune', 'Ahmedabad', 'Jaipur', 'Lucknow',
        ];

        $statuses = ['approved', 'approved', 'approved', 'pending']; // 75% approved

        foreach ($products as $categoryName => $items) {
            $category = $categories->firstWhere('name', $categoryName);
            if (!$category) continue;

            foreach ($items as $product) {
                // Create 3-5 entries per product across different dates and locations
                $entryCount = rand(3, 5);
                for ($i = 0; $i < $entryCount; $i++) {
                    $daysAgo = rand(1, 90);
                    MarketData::create([
                        'user_id' => $users->random()->id,
                        'product_name' => $product['name'],
                        'price' => round(rand($product['min'] * 100, $product['max'] * 100) / 100, 2),
                        'category_id' => $category->id,
                        'location' => $locations[array_rand($locations)],
                        'date' => Carbon::now()->subDays($daysAgo)->toDateString(),
                        'status' => $statuses[array_rand($statuses)],
                    ]);
                }
            }
        }
    }
}

<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'subcategory_id' => \App\Models\SubCategory::factory(),
            'brand_id' => \App\Models\Brand::factory(),
            'product_name' => $this->faker->word,
            'product_name_hin' => $this->faker->word,
            'product_code' => $this->faker->unique()->bothify('???###'),
            'product_quantity' => $this->faker->numberBetween(1, 100),
            'product_color' => $this->faker->randomElement(['red', 'green', 'blue']),
            'product_size' => $this->faker->randomElement(['S', 'M', 'L']),
            'selling_price' => $this->faker->randomFloat(2, 100, 500),
            'discount_price' => $this->faker->randomFloat(2, 50, 450),
            'video_link' => $this->faker->url,
            'main_slider' => $this->faker->boolean,
            'hot_deal' => $this->faker->boolean,
            'best_rated' => $this->faker->boolean,
            'mid_slider' => $this->faker->boolean,
            'hot_new' => $this->faker->boolean,
            'buyone_getone' => $this->faker->boolean,
            'trend' => $this->faker->boolean,
            'image_one' => 'upload/products/' . $this->faker->image('public/storage/upload/products', 640, 480, null, false),
            'image_two' => 'upload/products/' . $this->faker->image('public/storage/upload/products', 640, 480, null, false),
            'image_three' => 'upload/products/' . $this->faker->image('public/storage/upload/products', 640, 480, null, false),
            'status' => $this->faker->randomElement([1, 0]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

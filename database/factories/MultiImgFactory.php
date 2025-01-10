<?php

namespace Database\Factories;

use App\Models\MultiImg;
use Illuminate\Database\Eloquent\Factories\Factory;

class MultiImgFactory extends Factory
{
    protected $model = MultiImg::class;

    public function definition()
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'image' => 'upload/products/' . $this->faker->image('public/storage/upload/products', 640, 480, null, false),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

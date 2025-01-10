<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            'brand_name_en' => $this->faker->company,
            'brand_name_hin' => $this->faker->company,
            'brand_image' => 'upload/brand/' . $this->faker->image('public/storage/upload/brand', 640, 480, null, false),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

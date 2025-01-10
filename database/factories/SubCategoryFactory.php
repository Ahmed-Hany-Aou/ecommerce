<?php

namespace Database\Factories;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubCategoryFactory extends Factory
{
    protected $model = SubCategory::class;

    public function definition()
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'subcategory_name' => $this->faker->word,
            'subcategory_name_hin' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

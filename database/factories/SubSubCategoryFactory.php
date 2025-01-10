<?php

namespace Database\Factories;

use App\Models\SubSubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubSubCategoryFactory extends Factory
{
    protected $model = SubSubCategory::class;

    public function definition()
    {
        return [
            'category_id' => \App\Models\Category::factory(),
            'subcategory_id' => \App\Models\SubCategory::factory(),
            'subsubcategory_name' => $this->faker->word,
            'subsubcategory_name_hin' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

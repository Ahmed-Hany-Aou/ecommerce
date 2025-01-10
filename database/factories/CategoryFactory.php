<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'category_name_en' => $this->faker->word,
            'category_name_hin' => $this->faker->word,
            'category_icon' => 'fa-solid fa-circle',  // Example icon
            'category_slug_en' => $this->faker->slug,
            'category_slug_hin' => $this->faker->slug,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{
    protected $model = Slider::class;

    public function definition()
    {
        return [
            'slider_image' => 'upload/slider/' . $this->faker->image('public/storage/upload/slider', 640, 480, null, false),
            'status' => $this->faker->randomElement([1, 0]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

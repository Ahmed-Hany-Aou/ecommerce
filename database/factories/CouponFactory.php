<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition()
    {
        return [
            'coupon_code' => $this->faker->unique()->word,
            'coupon_value' => $this->faker->numberBetween(5, 30),
            'expiry_date' => $this->faker->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

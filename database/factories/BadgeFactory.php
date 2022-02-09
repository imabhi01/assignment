<?php

namespace Database\Factories;

use App\Models\Badge;
use Illuminate\Database\Eloquent\Factories\Factory;

class BadgeFactory extends Factory
{
    protected $model = Badge::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'badge_name' => $this->faker->text,
            'achievements' => $this->faker->randomDigit()
        ];
    }
}

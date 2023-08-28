<?php

namespace Database\Factories;

use App\Models\Courier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Courier>
 */
class CourierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'identity_code' => Str::random(32),
            'username' => Str::slug($this->faker->userName()),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'mobile' => "09213213121",
            'active' => true,
        ];
    }
}

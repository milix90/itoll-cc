<?php

namespace Database\Factories;

use App\Models\Invoker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Invoker>
 */
class InvokerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identity_code' => Str::random(32),
            'username' => Str::slug($this->faker->userName()),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => "02132129890",
            'active' => true,
        ];
    }
}

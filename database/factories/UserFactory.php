<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
final class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'last_name' => 'string',
        'first_name' => 'string',
        'email' => 'string',
        'email_verified_at' => "\Illuminate\Support\Carbon",
        'password' => 'string',
        'address' => 'string',
        'phone_number' => 'string',
    ])]
    public function definition(): array
    {
        return [
            'last_name' => fake()->lastname(),
            'first_name' => fake()->firstName(),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'userpassword',
            'address' => fake()->address(),
            'phone_number' => fake()->e164PhoneNumber(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

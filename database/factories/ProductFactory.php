<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
final class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = Brand::all('uuid')->pluck('uuid')->toArray();

        return [
            'price' => fake()->randomFloat(2, 0, 100),
            'description' => fake()->sentence(),
            'title' => fake()->word(),
            'metadata' => [
                'brand' => fake()->randomElement($brands),
                'image' => null,
            ],
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->name(),
            "image" => fake()->imageUrl(),
            "sell_price" => fake()->randomNumber(2),
            "buy_price" => fake()->randomNumber(2),
            "stock" => fake()->randomNumber(),
            "visits" => fake()->randomNumber()
        ];
    }
}

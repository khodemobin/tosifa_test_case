<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::factory()->create()->id,
            "product_id" => Product::factory()->create()->id,
            "quantity" => fake()->randomNumber(),
            "price" => fake()->randomNumber(2),
            "tax" => fake()->randomNumber(),
            "profit" => fake()->randomNumber(),
            "total" => fake()->randomNumber(2),
        ];
    }
}

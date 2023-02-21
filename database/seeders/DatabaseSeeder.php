<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Enums\PermissionAction;
use App\Models\Order;
use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user1 = User::factory()->create([
            "name" => "user1"
        ])->id;

        $user2 = User::factory()->create([
            "name" => "user2"
        ])->id;

        $user3 = User::factory()->create([
            "name" => "user3"
        ])->id;

        $product1 = \App\Models\Product::factory()->create(["user_id" => $user1,]);
        \App\Models\Order::factory()->create(["user_id" => $user1, "product_id" => $product1->id]);

        $product2 = \App\Models\Product::factory()->create(["user_id" => $user2,]);
        \App\Models\Order::factory()->create(["user_id" => $user2, "product_id" => $product2->id]);

        $product3 = \App\Models\Product::factory()->create(["user_id" => $user3,]);
        \App\Models\Order::factory()->create(["user_id" => $user3, "product_id" => $product3->id]);

        Permission::query()->insert([
            [
                "user_id" => $user1,
                "model" => Product::class,
                "action" => PermissionAction::VIEW,
                "fields" => json_encode(["name", "image"])
            ],
            [
                "user_id" => $user1,
                "model" => Product::class,
                "action" => PermissionAction::CREATE,
                "fields" => json_encode(["name", "image", "user_id"])
            ],
            [
                "user_id" => $user1,
                "model" => Order::class,
                "action" => PermissionAction::VIEW,
                "fields" => json_encode(["price", "quantity"])
            ],
            [
                "user_id" => $user2,
                "model" => Product::class,
                "action" => PermissionAction::UPDATE,
                "fields" => json_encode(["sell_price"])
            ],
            [
                "user_id" => $user2,
                "model" => Product::class,
                "action" => PermissionAction::VIEW,
                "fields" => json_encode(["name"])
            ],
            [
                "user_id" => $user3,
                "model" => Product::class,
                "action" => PermissionAction::VIEW,
                "fields" => json_encode(["*"])
            ],
            [
                "user_id" => $user3,
                "model" => Product::class,
                "action" => PermissionAction::CREATE,
                "fields" => json_encode(["*"])
            ],
            [
                "user_id" => $user3,
                "model" => Product::class,
                "action" => PermissionAction::UPDATE,
                "fields" => json_encode(["*"])
            ],
            [
                "user_id" => $user3,
                "model" => Product::class,
                "action" => PermissionAction::DELETE,
                "fields" => json_encode(["*"])
            ],

            [
                "user_id" => $user3,
                "model" => Order::class,
                "action" => PermissionAction::VIEW,
                "fields" => json_encode(["*"])
            ],
            [
                "user_id" => $user3,
                "model" => Order::class,
                "action" => PermissionAction::CREATE,
                "fields" => json_encode(["*"])
            ],
            [
                "user_id" => $user3,
                "model" => Order::class,
                "action" => PermissionAction::UPDATE,
                "fields" => json_encode(["*"])
            ],
            [
                "user_id" => $user3,
                "model" => Order::class,
                "action" => PermissionAction::DELETE,
                "fields" => json_encode(["*"])
            ],
            [
                "user_id" => null,
                "model" => Product::class,
                "action" => PermissionAction::VIEW,
                "fields" => json_encode(["sell_price"])
            ],
            [
                "user_id" => null,
                "model" => Order::class,
                "action" => PermissionAction::VIEW,
                "fields" => json_encode(["total"])
            ],
        ]);
    }
}

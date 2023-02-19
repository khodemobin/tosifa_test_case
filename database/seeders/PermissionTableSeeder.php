<?php

namespace Database\Seeders;

use App\Models\Enums\PermissionAction;
use App\Models\Order;
use App\Models\Permission;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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

        Permission::query()->insert([
            [
                "user_id" => $user1,
                "model" => Product::class,
                "action" => PermissionAction::VIEW,
                "fields" => json_encode(["name", "image"])
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
        ]);
    }
}

<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('check user permission for view specific columns', function () {

    \Pest\Laravel\seed();
    $user = \App\Models\User::query()->where("name", "user1")->first();

    $data = get("/api/products?user_id={$user->id}");
    $data->assertSee("name");
    $data->assertSee("image");
    $data->assertSee("sell_price");
});


it('update specific columns', function () {

    \Pest\Laravel\seed();
    $user = \App\Models\User::query()->where("name", "user2")->first();
    $product = \App\Models\Product::query()->where("user_id", $user->id)->first();

    post("/api/products/{$product->id}", [
        "user_id" => $user->id,
        "name" => "test",
        "sell_price" => 100
    ]);

    \Pest\Laravel\assertDatabaseHas("products", [
        "id" => $product->id,
        "user_id" => $user->id,
        "name" => $product->name,
        "sell_price" => 100
    ]);

    \Pest\Laravel\assertDatabaseMissing("products", [
        "id" => $product->id,
        "user_id" => $user->id,
        "name" => "test",
        "sell_price" => 100
    ]);
});


it('check user permission for view all columns', function () {

    \Pest\Laravel\seed();
    $user = \App\Models\User::query()->where("name", "user3")->first();

    $data = get("/api/products?user_id={$user->id}");
    $data->assertSee("name");
    $data->assertSee("image");
    $data->assertSee("sell_price");
    $data->assertSee("buy_price");
    $data->assertSee("stock");
    $data->assertSee("visits");
});

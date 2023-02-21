<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

beforeEach(function () {
    \Pest\Laravel\seed();
});

it('check user permission for view specific columns', function () {
    $user = \App\Models\User::query()->where("name", "user1")->first();

    $data = getJson("/api/products?user_id={$user?->id}");
    $data->assertSee("name");
    $data->assertSee("image");
    $data->assertSee("sell_price");
});


it('update specific columns', function () {
    $user = \App\Models\User::query()->where("name", "user2")->first();
    $product = \App\Models\Product::query()->where("user_id", $user?->id)->first();

    $res = postJson("/api/products/{$product?->id}", [
        "user_id" => $user?->id,
        "name" => "test",
        "sell_price" => 100
    ]);
    $this->assertEquals(false, $res->isOk());

    $res = postJson("/api/products/{$product?->id}", [
        "user_id" => $user?->id,
        "sell_price" => 100
    ]);

    $res->assertOk();

    \Pest\Laravel\assertDatabaseHas("products", [
        "id" => $product?->id,
        "user_id" => $user?->id,
        "name" => $product?->name,
        "sell_price" => 100
    ]);
});


it('check user permission for view all columns', function () {
    $user = \App\Models\User::query()->where("name", "user3")->first();

    $data = getJson("/api/products?user_id={$user?->id}");
    $data->assertSee("name");
    $data->assertSee("image");
    $data->assertSee("sell_price");
    $data->assertSee("buy_price");
    $data->assertSee("stock");
    $data->assertSee("visits");
    $data->assertSee("orders");
});

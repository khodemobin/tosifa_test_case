<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductController\IndexRequest;
use App\Http\Requests\ProductController\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Enums\PermissionAction;
use App\Models\Product;
use App\Models\User;
use App\Traits\HasPermission;

class ProductController extends Controller
{
    use HasPermission;

    public function index(IndexRequest $request)
    {
        cache()->flush();
        $user = User::find($request->get("user_id"));

        $products = Product::query()->where("user_id", $user->id)->with("orders")->simplePaginate()->items();

        $data = collect($products)->map(function ($item) {
            $product = self::checkPermissionForModel($item, PermissionAction::VIEW);
            $orders = self::checkPermissionForModel($item->orders, PermissionAction::VIEW);
            $product["orders"] = $orders;
            return $product;
        });


        return response()->json(ProductResource::collection($data));
    }

    public function update(Product $product, UpdateRequest $request)
    {
        $newProduct = new Product();
        foreach ($request->all() as $key => $item) {
            $newProduct->{$key} = $item;
        }


        $fields = $this::checkPermissionForData($newProduct, PermissionAction::UPDATE);

        $product->update($fields);

        return response()->json(new ProductResource($product));
    }
}

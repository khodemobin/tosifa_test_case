<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductController\IndexRequest;
use App\Http\Requests\ProductController\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Enums\PermissionAction;
use App\Models\Product;
use App\Models\User;
use App\Services\PermissionManger;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function __construct()
    {
        auth()->loginUsingId(request()?->get("user_id"));

    }

    public function index(IndexRequest $request, PermissionManger $permissionManger): JsonResponse
    {
        $user = User::find($request->get("user_id"));

        $products = Product::query()->where("user_id", $user->id)->with("orders")->simplePaginate()->items();

        $data = collect($products)->map(function ($item) use ($permissionManger) {
            $product = $permissionManger->removeUnAuthorizeFieldsFromModel($item, PermissionAction::VIEW);
            $orders = $permissionManger->removeUnAuthorizeFieldsFromCollection($item->orders, PermissionAction::VIEW);
            $product["orders"] = $orders;
            return $product;
        });

        return response()->json(ProductResource::collection($data));
    }

    public function update(Product $product, UpdateRequest $request): JsonResponse
    {
        Gate::authorize('model-permission', [Product::class, $request->all(), PermissionAction::UPDATE]);

        $product->update($request->all());

        return response()->json(new ProductResource($product));
    }
}

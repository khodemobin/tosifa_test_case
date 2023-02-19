<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user_id" => $this->whenHas("user_id"),
            "name" => $this->whenHas("name", $this["name"]),
            "image" => $this->whenHas("image", $this->image),
            "sell_price" => $this->whenHas("image", $this->sell_price),
            "buy_price" => $this->whenHas("buy_price", $this->buy_price),
            "stock" => $this->whenHas("stock", $this->stock),
            "visits" => $this->whenHas("stock", $this->visits),
            "orders" => OrderResource::collection($this->orders)
        ];
    }
}

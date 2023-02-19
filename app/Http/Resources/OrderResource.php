<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "user_id" => $this->whenHas("user_id", $this->user_id),
            "product_id" => $this->whenHas("product_id", $this->product_id),
            "quantity" => $this->whenHas("quantity", $this->quantity),
            "price" => $this->whenHas("price", $this->price),
            "tax" => $this->whenHas("tax", $this->tax),
            "profit" => $this->whenHas("profit", $this->profit),
            "total" => $this->whenHas("total", $this->total),
        ];
    }
}

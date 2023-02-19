<?php

namespace App\Http\Requests\ProductController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            "user_id" => ["required", Rule::exists("users", "id")],
            "name" => ["sometimes"],
            "image" => ["sometimes"],
            "sell_price" => ["sometimes"],
            "buy_price" => ["sometimes"],
            "stock" => ["sometimes"],
            "visits" => ["sometimes"],
        ];
    }

    public function authorize()
    {
        return true;
    }
}

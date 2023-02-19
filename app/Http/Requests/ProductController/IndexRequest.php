<?php

namespace App\Http\Requests\ProductController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    public function rules()
    {
        return [
            "user_id" => ["required", Rule::exists("users", "id")]
        ];
    }

    public function authorize()
    {
        return true;
    }
}

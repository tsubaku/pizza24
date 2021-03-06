<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:200|unique:products,title,',
            'slug' => 'unique:products,slug,',
            'category_id' =>'required|integer|exists:categories,id',
            'description' =>'string|min:3|max:1000',
            'price' =>'required|numeric|between:0.01,999.99',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_published' =>'required|boolean',
        ];
    }
}

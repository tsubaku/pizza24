<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends FormRequest
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
            'title' => 'required|min:3|max:200|unique:categories,title,',
            'slug' => 'unique:categories,slug,',
            'parent_id' =>'required|integer|exists:categories,id',
            'description' =>'string|min:3|max:1000',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}

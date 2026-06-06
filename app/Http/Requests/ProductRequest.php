<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId  = $this->route('product')?->id;
        $imageRules = $this->isMethod('POST')
            ? ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048']
            : ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'];

        return [
            'category_id'    => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:subcategories,id'],
            'name'           => [
                'required', 'string', 'min:2', 'max:200',
                Rule::unique('products', 'name')->ignore($productId)->whereNull('deleted_at'),
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'image'       => $imageRules,
            'old_price'   => ['nullable', 'numeric', 'min:0', 'max:9999999'],
            'new_price'   => ['required', 'numeric', 'min:0', 'max:9999999'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required'    => 'Please select a category.',
            'subcategory_id.required' => 'Please select a subcategory.',
            'name.required'           => 'Product name is required.',
            'name.unique'             => 'A product with this name already exists.',
            'image.required'          => 'Product image is required.',
            'image.image'             => 'File must be an image.',
            'image.mimes'             => 'Image must be jpeg, jpg, png, or webp.',
            'image.max'               => 'Image size must not exceed 2MB.',
            'new_price.required'      => 'Selling price is required.',
            'new_price.numeric'       => 'Price must be a number.',
            'old_price.numeric'       => 'Old price must be a number.',
        ];
    }
}

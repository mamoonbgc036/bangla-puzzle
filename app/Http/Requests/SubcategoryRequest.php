<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubcategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $subcategoryId = $this->route('subcategory')?->id;

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
                Rule::unique('subcategories', 'name')->ignore($subcategoryId)->whereNull('deleted_at'),
            ],
            'description' => ['nullable', 'string', 'max:500'],
            'is_active'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category.',
            'category_id.exists'   => 'Selected category does not exist.',
            'name.required'        => 'Subcategory name is required.',
            'name.unique'          => 'This subcategory name already exists.',
            'name.min'             => 'Subcategory name must be at least 2 characters.',
            'name.max'             => 'Subcategory name may not exceed 100 characters.',
        ];
    }
}

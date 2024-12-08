<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $product = $this->route('product');

        return match ($this->route()->getName()) {
            'products.store' => [
                'category_id' => [ 'required', 'exists:categories,id' ],
                'name' =>  ['required', 'string', 'max:255', 'unique:products,name'],
                'description' =>  ['nullable', 'string', 'max:500'],
            ],
            'products.update' => [
                'category_id' => [ 'required', 'exists:categories,id' ],
                'name' =>  ['required', 'string', 'max:255', 'unique:products,name,'.$product->id],
                'description' =>  ['nullable', 'string', 'max:500'],
            ],
            default => []
        };
    }
}

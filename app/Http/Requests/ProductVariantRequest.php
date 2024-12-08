<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductVariantRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $variant = $this->route('variant'); // Route'dan olingan variant

        return match ($this->route()->getName()) {
            'variants.create' => [
                'product_id' => ['required', 'exists:products,id', 'integer'],
                'size_id' => ['required', 'exists:sizes,id', 'integer'],
                'product_id.size_id' => 'unique:product_variants,product_id,NULL,id,size_id,' . $this->input('size_id'),
            ],

            'variants.update' => [
                'product_id' => ['required', 'exists:products,id', 'integer'],
                'size_id' => ['required', 'exists:sizes,id', 'integer'],
                'product_id.size_id' => 'unique:product_variants,product_id,' . $variant->id . ',id,size_id,' . $this->input('size_id'),
            ]
        };
    }

}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\ProductVariant;

class ProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $variant = $this->route('variant');

        return [
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('product_variants')
                    ->where('size_id', $this->input('size_id'))
                    ->ignore($variant?->id),
            ],
            'size_id' => ['required', 'exists:sizes,id', 'integer'],
            'sku' => [
                'required',
                'string',
                Rule::unique('product_variants', 'sku'),
                'regex:/^SKU-\d+$/',
            ],
        ];
    }



    protected function prepareForValidation(): void
    {
        if ($this->isMethod('POST')) {
            $this->merge([
                'sku' => $this->generateSku(),
            ]);
        }
    }

    private function generateSku(): string
    {
        $lastSku = ProductVariant::where('sku', 'like', 'SKU-%')
            ->orderByRaw('CAST(SUBSTRING(sku, 5) AS UNSIGNED) DESC')
            ->value('sku');

        $nextNumber = $lastSku ? ((int) substr($lastSku, 4) + 1) : 10001;

        return 'SKU-' . $nextNumber;
    }
}

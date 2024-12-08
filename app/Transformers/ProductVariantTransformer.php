<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProductVariant;

class ProductVariantTransformer extends TransformerAbstract
{
    public function transform(ProductVariant $model): array
    {
        return [
            'product_id' => app(ProductTransformer::class )->transform($model->product),
            'size_id' => app(SizeTransformer::class )->transform($model->size)
        ];
    }
}

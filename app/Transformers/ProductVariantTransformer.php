<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProductVariant;

class ProductVariantTransformer extends TransformerAbstract
{
    public function transform(ProductVariant $model): array
    {
        return [
            'id' => $model->id,
            'product' => app(ProductTransformer::class )->transform($model->product),
            'size' => app(SizeTransformer::class )->transform($model->size),
            'sku' => $model->sku,
        ];
    }
}

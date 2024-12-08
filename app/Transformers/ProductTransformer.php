<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Product;

class ProductTransformer extends TransformerAbstract
{
    public function transform(Product $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'description' => $model->description,
            'category' => app(CategoryTransformer::class)->transform($model->category)
        ];
    }
}

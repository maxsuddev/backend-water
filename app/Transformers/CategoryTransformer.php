<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Category;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $model): array
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'username' => $model->username,
        ];
    }
}
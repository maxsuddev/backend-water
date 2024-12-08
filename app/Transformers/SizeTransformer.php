<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Size;

class SizeTransformer extends TransformerAbstract
{
    public function transform(Size $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name
        ];
    }
}

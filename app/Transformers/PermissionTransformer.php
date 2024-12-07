<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $model): array
    {
        return [
            'id'  => $model->id,
            'name' => $model->name,
        ];
    }
}

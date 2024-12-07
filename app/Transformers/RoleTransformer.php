<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;
use App\Models\Role;

class RoleTransformer extends TransformerAbstract
{
    /**
     * Преобразовать сущность Role.
     *
     * @param Role $model
     * @return array
     */
    public function transform(Role $model): array
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'permissions' => $this->transformPermissions($model->permissions),
        ];
    }

    /**
     * Преобразовать разрешения, связанные с ролью.
     *
     * @param Collection $permissions
     * @return array
     */
    protected function transformPermissions($permissions): array
    {
        return $permissions->map(function ($permission) {
            return [
                'id' => (int) $permission->id,
                'name' => $permission->name,
                'slug' => $permission->slug,

            ];
        })->toArray();
    }
}

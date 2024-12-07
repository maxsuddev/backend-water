<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \App\Models\User $model
     *
     * @return array
     */
    public function transform(User $model): array
    {
        return [
            'id'         => (int) $model->id,
            'username'  => $model->username,
            'name'  => $model->name,
            'roles' => $this->transformRoles($model->roles),
        ];
    }

    protected function transformRoles($roles): array
    {
        return $roles->map(function ($role) {
            return [
                'id' => (int) $role->id,
                'name' => $role->name,
                'slug' => $role->slug,

            ];
        })->toArray();
    }


}

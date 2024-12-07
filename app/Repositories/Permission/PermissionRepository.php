<?php

namespace App\Repositories\Permission;

use App\Models\Permission;
use App\Presenters\PermissionPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function model(): string
    {
        return Permission::class;
    }

    /**
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter(): string
    {
        return PermissionPresenter::class;
    }

    protected $fieldSearchable = [

    ];
}

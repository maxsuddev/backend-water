<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Presenters\CategoryPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function model(): string
    {
        return Category::class;
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
        return CategoryPresenter::class;
    }

    protected $fieldSearchable = [
        'name' => 'like',
        'id'
    ];
}

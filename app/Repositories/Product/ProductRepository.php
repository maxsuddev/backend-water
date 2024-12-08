<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Presenters\ProductPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function model(): string
    {
        return Product::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter(): string
    {
        return ProductPresenter::class;
    }

    protected $fieldSearchable = [

    ];
}
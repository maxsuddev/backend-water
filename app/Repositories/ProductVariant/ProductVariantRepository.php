<?php

namespace App\Repositories\ProductVariant;

use App\Models\ProductVariant;
use App\Presenters\ProductVariantPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class ProductVariantRepository extends BaseRepository implements ProductVariantRepositoryInterface
{
    public function model(): string
    {
        return ProductVariant::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter(): string
    {
        return ProductVariantPresenter::class;
    }

    protected $fieldSearchable = [

    ];
}
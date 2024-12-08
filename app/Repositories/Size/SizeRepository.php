<?php

namespace App\Repositories\Size;

use App\Models\Size;
use App\Presenters\SizePresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class SizeRepository extends BaseRepository implements SizeRepositoryInterface
{
    public function model(): string
    {
        return Size::class;
    }

    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter(): string
    {
        return SizePresenter::class;
    }

    protected $fieldSearchable = [

    ];
}
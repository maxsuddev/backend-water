<?php

namespace App\Presenters;

use App\Transformers\CategoryTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

class CategoryPresenter extends FractalPresenter
{
    public function getTransformer(): TransformerAbstract
    {
        return new CategoryTransformer();
    }
}
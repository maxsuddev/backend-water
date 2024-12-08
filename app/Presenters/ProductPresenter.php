<?php

namespace App\Presenters;

use App\Transformers\ProductTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

class ProductPresenter extends FractalPresenter
{
    public function getTransformer(): TransformerAbstract
    {
        return new ProductTransformer();
    }
}
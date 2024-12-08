<?php

namespace App\Presenters;

use App\Transformers\ProductVariantTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

class ProductVariantPresenter extends FractalPresenter
{
    public function getTransformer(): TransformerAbstract
    {
        return new ProductVariantTransformer();
    }
}
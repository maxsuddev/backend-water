<?php

namespace App\Presenters;

use App\Transformers\SizeTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

class SizePresenter extends FractalPresenter
{
    public function getTransformer(): TransformerAbstract
    {
        return new SizeTransformer();
    }
}
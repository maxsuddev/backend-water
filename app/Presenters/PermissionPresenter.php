<?php

namespace App\Presenters;

use App\Transformers\PermissionTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

class PermissionPresenter extends FractalPresenter
{
    public function getTransformer(): TransformerAbstract
    {
        return new PermissionTransformer();
    }
}
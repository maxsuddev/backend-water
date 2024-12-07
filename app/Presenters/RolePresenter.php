<?php

namespace App\Presenters;

use App\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 *
 * @package namespace App\Presenters;
 */
class RolePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return TransformerAbstract
     */
    public function getTransformer(): RoleTransformer|TransformerAbstract
    {
        return new RoleTransformer();
    }
}

<?php

namespace App\Presenters;

use App\Transformers\UserTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 *
 * @package namespace App\Presenters;
 */
class UserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return TransformerAbstract
     */
    public function getTransformer(): UserTransformer|TransformerAbstract
    {
        return new UserTransformer();
    }
}

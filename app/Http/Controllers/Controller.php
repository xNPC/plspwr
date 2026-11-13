<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\SeoPresenter;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    protected function settings(): Setting
    {
        return view()->shared('settings');
    }

    protected function seoFor($model, array $defaults = []): SeoPresenter
    {
        $presenter = new SeoPresenter($model, $defaults);

        app()->instance(SeoPresenter::class, $presenter);

        return $presenter;
    }
}

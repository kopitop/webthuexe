<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Category;
use App\Car;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $viewData;

    public function __construct()
    {
        $this->viewData['categories'] = Category::with(['cars' => function ($query) {
            $query->limit(1);
        }])->get();

        $this->viewData['cars'] = Car::with('category')->where('status', '!=', config('vars.cars.status.suspend'))->get();

        $this->viewData['url'] = request()->route()->uri;
    }
}

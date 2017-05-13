<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Car;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $this->viewData['randomCars'] = $this->viewData['cars'];

        if($this->viewData['cars']->count() > 5) {
            $this->viewData['randomCars'] = $this->viewData['cars']->random(5);
        }

        return view('home', $this->viewData);
    }
}

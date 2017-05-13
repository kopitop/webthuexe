<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['orders'] = \App\Order::all();
        $this->viewData['pendingOrders'] = \App\Order::pendingOrders();
        $this->viewData['cars'] = \App\Car::all();
        $this->viewData['users'] = \App\User::all();

        return view('admin.home', $this->viewData);
    }
}

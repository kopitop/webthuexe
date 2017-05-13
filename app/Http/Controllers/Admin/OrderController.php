<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('today')) {
            $this->viewData['orders'] = Order::with(['user', 'car'])
            ->orWhereDate('begin', '=',\DB::raw('CURDATE()'))
            ->orWhereDate('end', '=',\DB::raw('CURDATE()'))->get();
        } else {
            $this->viewData['orders'] = Order::with(['user', 'car'])->get();
        }

        return view('admin/orders/index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($order->status != config('vars.order.status.pending')) {
            return back()->withErrors('Không thể xác nhậh đơn hàng này');
        }

        $car = $order->car;

        if ($car->status == config('vars.car.status.suspend')) {
            return back()->withErrors('Bạn không thể xác nhận đơn hàng này do xe ngừng hoạt động');
        }

        $approvedOrdersOfCar = $car->approvedOrders()->get();
        $flag = false;
        $approvedOrdersOfCar->each(function($approvedOrder) use ($order, &$flag) {
            $startMax = $approvedOrder->begin->max($order->begin);
            $endMin = $approvedOrder->end->min($order->end);

            if ($startMax < $endMin) {
                $flag = true;
                return;
            }
        });

        if ($flag) {
            return redirect()->back()->withErrors('Bạn không thể xác nhận đơn hàng này do xe đã được sử dụng vào thời gian này');
        }

        $order->status = config('vars.order.status.approved');
        if($order->save()) {
            return back()->withSuccess('Bạn đã xác nhận đơn hàng này');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status != config('vars.order.status.pending')) {
            return back()->withErrors('Không thể xoá đơn hàng này');
        }

        $order->status = config('vars.order.status.rejected');
        if($order->save()) {
            return back()->withSuccess('Bạn đã huỷ đơn hàng này');
        }
    }
}

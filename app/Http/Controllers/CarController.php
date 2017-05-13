<?php

namespace App\Http\Controllers;

use App\Category;
use App\Car;
use App\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'sort_by' => 'in:name,title,price',
            'asc' => 'in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect(config('app.url'));
        }

        $query = Car::select('*');

        $keyword = $request->input('keyword');

        \Log::debug($keyword);
        if ($keyword) {
            $columns = [
                'title', 'name', 'desc'
            ];
            foreach($columns as $column)
            {
              $query->orWhere($column, 'like', '%' . (string)$keyword . '%');
            }
        }
        \Log::debug('ok');

        $sortBy = $request->input('sort_by');
        $sortAsc = !is_null($request->input('asc')) ? ($request->input('asc') ? 'asc' : 'desc') : 'asc';

        if($sortBy && $sortAsc) {
            $query->orderBy($sortBy, $sortAsc);
        }

        $carsBySearch = $query->simplePaginate(3);

        $this->viewData['carsBySearch'] = $carsBySearch;

        return view('client.cars', $this->viewData);
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Car $car, $slug)
    {
        preg_match(config('vars.regex.idFromSlug'), $slug, $matches);

        \Log::debug($matches);
        $id = $matches ? $matches[0] : nul;
        
        $this->viewData['car'] = $car->findOrFail($id);
        $this->viewData['relatedCars'] = $category->findOrFail($this->viewData['car']->category_id)->cars;

        return view('client.car', $this->viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request, $slug)
    {
        try {
            $this->validate($request, [
                'begin' => 'required|date|after:yesterday',
                'end' => 'required|date|after:begin',
            ]);

            preg_match(config('vars.regex.idFromSlug'), $slug, $matches);
            $id = $matches[0];
            
            $car = Car::findOrFail($id);

            $begin = Carbon::parse($request->input('begin'));
            $end = Carbon::parse($request->input('end'));

            Order::create([
                'car_id' => $id,
                'user_id' => \Auth::user()->id,
                'begin' => $begin,
                'end' => $end,
                'total' => $end->diffInDays($begin) * $car->price,
            ]);

            return back()->withSuccess('Đặt xe thành công, chúng tôi sẽ liên hệ lại để xác nhận ngay!');
            
        } catch (Exception $e) {
            return back()->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
        }
    }
}


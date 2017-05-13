<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Car;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('withSuspend')) {
            $this->viewData['cars'] = Car::with('category')->get();
        } else {
            $this->viewData['cars'] = Car::where('status', '!=', config('vars.car.status.suspend'))->get();
        }

        return view('admin/cars/index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->viewData['categories'] = Category::all();

        return view('admin/cars/create', $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:255|alpha_dash',
                'title' => 'required|max:255',
                'price' => 'required|numeric|min:1',
                'category_id' => 'required|exists:categories,id',
            ]);

            $input = $request->input();
            $input['slug'] = str_slug($request->input('title'));
            if ($request->file('photo')->isValid()) {
                //upload
                $photo = $request->file('photo');
                $destinationPath = 'uploads'; // upload path
                $extension = $photo->getClientOriginalExtension(); // getting image extension
                $fileName = str_random(40).'.'.$extension; // renameing image
                $photo->move($destinationPath, $fileName); // uploading file to given path

                $input['img'] = $fileName;
            }
            $input['status'] = config('vars.car.status.available');

            if (Car::create($input)) {
                return back()->withSuccess('Bạn đã thành công');
            }
        } catch (Exception $e) {
            return back()->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
        }
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
        $this->viewData['car'] = Car::findOrFail($id);
        $this->viewData['categories'] = Category::all();

        return view('admin/cars/edit', $this->viewData);
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
        try {
            $this->validate($request, [
                'name' => 'max:255|alpha_dash',
                'title' => 'max:255',
                'price' => 'numeric|min:1',
                'category_id' => 'exists:categories,id',
            ]);

            $car = Car::findOrFail($id);

            if ($car->status == config('vars.car.status.rented')) {
                return back()->withErrors('Xe này đang được cho thuê');
            }

            $car->name = $request->input('name') ? $request->input('name') : $car->name;
            $car->title = $request->input('title') ? $request->input('title') : $car->title;
            $car->slug = $request->input('title') ? str_slug($request->input('title')) : $car->slug;
            $car->desc = $request->input('desc') ? $request->input('desc') : $car->desc;
            $car->status = $request->input('status') ? ($request->input('status') === 'on' ? config('vars.car.status.available') : config('vars.car.status.suspend')) : $car->status;
            $car->price = $request->input('price') ? $request->input('price') : $car->price;
            $car->category_id = $request->input('category_id') ? $request->input('category_id') : $car->category_id;

            if ($request->file('photo')->isValid()) {
                //upload
                $photo = $request->file('photo');
                $destinationPath = 'uploads'; // upload path
                $extension = $photo->getClientOriginalExtension(); // getting image extension
                $fileName = str_random(40).'.'.$extension; // renameing image
                $photo->move($destinationPath, $fileName); // uploading file to given path

                $car->img = $fileName;
            }

            if ($car->save()) {
                return redirect('/quan-tri/cars')->withSuccess('Bạn đã chỉnh sửa xe có ID là ' . $id . 'thành công');
            }
        } catch (Exception $e) {
            return redirect('quan-tri/cars')->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
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
        try {
            $car = Car::findOrFail($id);
            if ($car->status === config('vars.car.status.rented')) {
                return back()->withErrors('Xe này đang được cho thuê');
            }

            $car->status = config('vars.car.status.suspend');

            if ($car->save()) {
                return back()->withSuccess('Bạn đã ngừng sử dụng xe có ID là ' . $id . 'thành công');
            }
        } catch (Exception $e) {
            return back()->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
        }
    }
}

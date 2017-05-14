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
            $this->viewData['cars'] = Car::where('trang_thai', '!=', config('vars.car.status.suspend'))->get();
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
            $validator = \Validator::make($request->all(), [
                'ten' => 'required|max:255|alpha_dash',
                'ten_hien_thi' => 'required|max:255',
                'gia' => 'required|numeric|min:1',
                'danh_muc_id' => 'required|exists:danh_muc,id',
            ]);

            if ($validator->fails()) {
                return redirect('/quan-tri/cars')->withErrors($validator)->withInput();
            }

            $input = $request->input();
            $input['ten_url'] = str_slug($request->input('ten_hien_thi'));
            $input['gioi_thieu'] = $request->input('gioi_thieu');
            if ($request->file('photo')->isValid()) {
                $path = $request->file('photo')->store('uploads');

                \Log::debug($path);

                $input['anh'] = $path;
            }
            $input['trang_thai'] = config('vars.car.status.available');

            if (Car::create($input)) {
                return redirect('/quan-tri/cars')->withSuccess('Bạn đã thành công');
            }
        } catch (Exception $e) {
            return redirect('/quan-tri/cars')->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
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
        abort(404);
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
            $validator = \Validator::make($request->all(), [
                'ten' => 'max:255|alpha_dash',
                'ten_hien_thi' => 'max:255',
                'gia' => 'numeric|min:1',
                'danh_muc_id' => 'exists:categories,id',
            ]);

            if ($validator->fails()) {
                return redirect('/quan-tri/cars');
            }

            \Log::debug('validate ok');

            $car = Car::findOrFail($id);

            if ($car->trang_thai == config('vars.car.status.rented')) {
                return redirect('/quan-tri/cars')->withErrors('Xe này đang được cho thuê');
            }

            \Log::debug('rented ok');

            $car->ten = $request->input('ten') ? $request->input('ten') : $car->ten;
            $car->ten_hien_thi = $request->input('ten_hien_thi') ? $request->input('ten_hien_thi') : $car->ten_hien_thi;
            $car->ten_url = $request->input('ten_hien_thi') ? str_slug($request->input('ten_hien_thi')) : $car->ten_url;
            $car->gioi_thieu = $request->input('gioi_thieu') ? $request->input('gioi_thieu') : $car->gioi_thieu;
            $car->trang_thai = $request->input('trang_thai') ? ($request->input('trang_thai') === 'on' ? config('vars.car.status.available') : config('vars.car.status.suspend')) : $car->trang_thai;
            $car->gia = $request->input('gia') ? $request->input('gia') : $car->gia;
            $car->danh_muc_id = $request->input('danh_muc_id') ? $request->input('danh_muc_id') : $car->danh_muc_id;

            if ($request->file('photo') && $request->file('photo')->isValid()) {
                $path = $request->file('photo')->store('uploads');

                \Log::debug($path);

                $car->anh = $path;
            }

            if ($car->save()) {
                return redirect('/quan-tri/cars')->withSuccess('Bạn đã chỉnh sửa xe có ID là ' . $id . 'thành công');
            }

            \Log::debug('save fail');

        } catch (Exception $e) {
            return redirect('/quan-tri/cars')->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
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
            if ($car->trang_thai === config('vars.car.status.rented')) {
                return back()->withErrors('Xe này đang được cho thuê');
            }

            $car->trang_thai = config('vars.car.status.suspend');

            if ($car->save()) {
                return redirect('/quan-tri/cars')->withSuccess('Bạn đã ngừng sử dụng xe có ID là ' . $id . 'thành công');
            }
        } catch (Exception $e) {
            return redirect('/quan-tri/cars')->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
        }
    }
}

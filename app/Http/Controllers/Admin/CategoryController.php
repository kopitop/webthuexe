<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['categories'] = Category::with('parent')->get();

        return view('admin/categories/index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->viewData['categories'] = Category::all();

        return view('admin/categories/create', $this->viewData);
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
                'ten' => 'required|max:255|alpha_dash',
                'ten_hien_thi' => 'required',
                'danh_muc_cha_id' => 'exists:danh_muc,id',
            ]);

            $input = $request->input();
            $input['ten_url'] = str_slug($request->input('ten_hien_thi'));
            if (!array_key_exists('danh_muc_cha_id', $input)) {
                $input['danh_muc_cha_id'] = 0;
            }

            if (Category::create($input)) {
                return redirect('/quan-tri/categories')->withSuccess('Bạn đã khởi tạo danh mục thành công');
            }
        } catch (Exception $e) {
            return redirect('/quan-tri/categories')->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
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
        $this->viewData['category'] = Category::findOrFail($id);
        $this->viewData['categories'] = Category::all();

        return view('admin/categories/edit', $this->viewData);
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
            $category = Category::findOrFail($id);
            if ($category->children()->count() && ($request->input('danh_muc_cha_id') !== $category->danh_muc_cha_id)) {
                return back()->withErrors('Chỉ có thể thay đổi cha của 1 thư mục rỗng');
            }

            if (($request->input('danh_muc_cha_id') == $id)) {
                return back()->withErrors('Không thể là cha của chính mình');
            }

            $category->ten_hien_thi = $request->input('ten_hien_thi');
            $category->ten = $request->input('ten');
            $category->danh_muc_cha_id = $request->input('danh_muc_cha_id') ? $request->input('danh_muc_cha_id') : $category->danh_muc_cha_id;
            $category->gioi_thieu = $request->input('gioi_thieu');
            $category->ten_url = str_slug($request->input('ten_hien_thi'));

            if ($category->save()) {
                return back()->withSuccess('Bạn đã chỉnh sửa danh muc có ID là ' . $id . 'thành công');
            }
        } catch (Exception $e) {
            return back()->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
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
            $category = Category::findOrFail($id);
            if ($category->children()->count()) {
                return back()->withErrors('Bạn chỉ được phép xoá menu rỗng!');
            }

            if ($category->delete()) {
                return back()->withSuccess('Bạn đã xoá menu có ID là ' . $id . 'thành công');
            }
        } catch (Exception $e) {
            return back()->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->viewData['users'] = User::all();

        return view('admin/users/index', $this->viewData);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/users/create');
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
                'name' => 'required|max:255',
                'email' => 'required|unique:users',
                'role' => 'required|in:0,1',
                'password' => 'required|confirmed',
            ]);

            if (User::create($request->input())) {
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
        $this->viewData['user'] = User::findOrFail($id);

        return view('admin/users/detail', $this->viewData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->viewData['user'] = User::findOrFail($id);

        return view('admin/users/edit', $this->viewData);
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
            $user = User::findOrFail($id);

            if ($user->isCurrent()) {
                return back()->withErrors('Bạn không thể chỉnh sửa chính mình được!!!');
            }

            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->role = $request->input('role');

            if ($user->save()) {
                return back()->withSuccess('Bạn đã chỉnh sửa thành viên có ID là ' . $id . 'thành công');
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
            $user = User::findOrFail($id);
            if ($user->isCurrent()) {
                return back()->withErrors('Bạn không thể xoá chính mình được!!!');
            }

            if (!User::count() > 1) {
                return back()->withErrors('Phải có ít nhất 1 quản trị viên');
            }

            if ($user->delete()) {
                return back()->withSuccess('Bạn đã xoá thành viên có ID là ' . $id . 'thành công');
            }
        } catch (Exception $e) {
            return back()->withErrors('Lỗi hệ thống đã xảy ra, vui lòng liên hệ Admin');
        }

    }
}

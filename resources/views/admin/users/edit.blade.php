@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=>{{ Request::segment(1) }}</li>
        <li class="active">Thông tin người dùng</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content clearfix">
      <div class="col-md-offset-3 col-md-6">
        <div class="box box-info">
        @if ( session()->has('success') )
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            {{ session()->get('success') }}
          </div>
          @endif

          @if ( session()->has('errors') )
            @foreach (session()->get('errors')->messages() as $error)
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{ $error[0] }}
              </div>
            @endforeach
          @endif
          <div class="box-header with-border">
            <h3 class="box-title">User Profile</h3>
          </div>
          <form method="POST" action="/users/{{ $user->id }}">
            <div class="box-body">
              {{ method_field('PUT') }}
              {{ csrf_field() }}
              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input name="name" type="text" class="form-control" placeholder="Họ và tên" value="{{ $user->name }}">
              </div>
              <br>

              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input name="email" type="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
              </div>
              <br>

              <div class="form-group">
                <label>Chọn level cho thành viên này</label>
                <select name="role" class="form-control">
                  <option value="0" @if (!$user->isAdmin()) {{ 'selected' }} @endif>Member</option>
                  <option value="1" @if ($user->isAdmin()) {{ 'selected' }} @endif>Admin</option>
                </select>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Xác Nhận</button>
              <button type="reset" class="btn btn-warning">Làm lại</button>
            </div>
          </form>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
@endsection

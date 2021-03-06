@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Danh mục
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=>{{ Request::segment(1) }}</li>
        <li class="active"> Tạo mới danh mục</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content clearfix">
      <div class="col-md-offset-3 col-md-6">
        <div class="box box-info">
        @if ( session()->has('success') )
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i>Thông báo !</h4>
            {{ session()->get('success') }}
          </div>
          @endif

          @if ( session()->has('errors') )
            @foreach (session()->get('errors')->messages() as $error)
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i>Thông báo !</h4>
                {{ $error[0] }}
              </div>
            @endforeach
          @endif
          <div class="box-header with-border">
            <h3 class="box-title">Danh mục</h3>
          </div>
          <form method="POST" action="/categories">
            <div class="box-body">
              {{ csrf_field() }}
              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input name="name" type="text" class="form-control" placeholder="Tên danh mục" value="{{ old('name') }}">
              </div>
              <br>

              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input name="title" type="text" class="form-control" placeholder="Tên hiển thị" value="{{ old('title') }}">
              </div>
              <br>

              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input name="desc" type="text" class="form-control" placeholder="Mô tả" value="{{ old('desc') }}">
              </div>
              <br>

              <div class="form-group">
                <label>Chọn cha cho danh mục này</label>
                {!! nestable($categories->toArray())->attr(['name' => 'parent_id', 'class' => 'form-control'])
                    ->renderAsDropdown()
                !!}
              </div>
              <br>
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

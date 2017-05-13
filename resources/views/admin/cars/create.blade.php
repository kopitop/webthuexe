@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Xe cho 
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class=>{{ Request::segment(1) }}</li>
        <li class="active"> Tạo mới xe</li>
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
            <h3 class="box-title">Xe</h3>
          </div>
          <form method="POST" action="/quan-tri/cars" enctype="multipart/form-data">
            <div class="box-body">
              {{ csrf_field() }}
              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input name="name" type="text" class="form-control" placeholder="Tên xe" value="{{ old('name') }}">
              </div>
              <br>

              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input name="title" type="text" class="form-control" placeholder="Tên hiển thị xe" value="{{ old('title') }}">
              </div>
              <br>

              <div class="input-group">
                <input type="text" class="form-control price" placeholder="Giá cho thuê theo ngày">
                <input type="hidden" class="price-value" name="price" value="{{ old('price') }}">
                <span class="input-group-addon">.00</span>
              </div>
              <br>

              <div class="form-group">
                <label>Chọn danh mục cho xe này</label>
                {!! nestable($categories->toArray())->attr(['name' => 'category_id', 'class' => 'form-control'])
                  ->selected(old('category_id'))
                    ->renderAsDropdown()
                !!}
              </div>
              <br>

              <div class="form-group">
                <label for="exampleInputFile">Hình ảnh</label>
                <input type="file" id="exampleInputFile" name="photo">

                <p class="help-block">Hãy chọn 1 hình đại diện</p>
              </div>

              <textarea class="textarea" placeholder="Giới thiệu chiếc xe này" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>

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
@push('script')
<script type="text/javascript" src="/admin/plugins/jquery.formatCurrency-1.4.0.min.js"></script>
<script type="text/javascript">
  $('.price-value').formatCurrency('.price');
  $('.price').blur(function() {
      $('.price-value').val($('.price').formatCurrency().asNumber());
  });
  $(".textarea").wysihtml5();
</script>
@endpush
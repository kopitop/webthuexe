@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Danh sach xe
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ Request::segment(1) }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Hover Data Table</h3>
              <div style="display:flex">
                <a href="/quan-tri/cars/?withSuspend=true" class="btn btn-block btn-primary btn-sm" style="margin-right:15px; width: 200px">Xem cả xe đã ngừng sử dụng</a>
                <a href="/quan-tri/cars/" class="btn btn-block btn-info btn-sm" style="width: 200px; margin-top: 0;">Chỉ xem xe đang sử dụng</a>
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
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

              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên xe</th>
                  <th>Tên hiển thị</th>
                  <th>Menu cha</th>
                  <th>Photo</th>
                  <th>Tóm tắt</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cars as $car)
                  <tr>
                    <td>{{ $car->id }}</td>
                    <td><a href="/quan-tri/cars/{{ $car->id }}/edit">{{ $car->name }}</a></td>
                    <td>{{ $car->title }}</td>
                    <td><a href="/quan-tri/categories/{{ $car->category['id'] }}/edit">{{ $car->category['title'] }}</a></td>
                    <td><img src="/anh-upload/{{ $car->img }}" style="width: 50px; height= 50px"></td>
                    <td>{{ str_limit($car->desc, 100) }}</td>
                    <td>{{ $car->status == 0 ? 'Ngừng cho thuê' : 'Sẵn sàng cho thuê' }}</td>
                    <td style="display: flex">
                      <a href="quan-tri/cars/{{ $car->id }}/edit" class="btn btn-block btn-primary">Sửa</a>
                      <a class="btn btn-block btn-danger" style="
                        margin-top: 0;
                      "
                          onclick="event.preventDefault();
                          if (!confirm('Bạn chắc chắn muốn ngừng sử dụng chiếc xe này chứ?')) { return false; };
                          document.getElementById('delete-form-{{ $car->id }}').submit();">
                        Ngừng
                      </a>
                      <form id="delete-form-{{ $car->id }}" action="/quan-tri/cars/{{ $car->id }}" method="POST" style="display: none;">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                      </form>
                    </td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Tên xe</th>
                  <th>Tên hiển thị</th>
                  <th>Menu cha</th>
                  <th>Photo</th>
                  <th>Tóm tắt</th>
                  <th>Thao tác</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
@endsection

@push('script')
<script type="text/javascript" src="/admin/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/plugins/dataTables.bootstrap.min.js"></script>
<script>
  $('#example2').DataTable();
</script>
@endpush
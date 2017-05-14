@extends('layouts.admin')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Danh sach hoá đơn
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
                <a href="/quan-tri/orders/?today=true" class="btn btn-block btn-primary btn-sm" style="margin-right:15px; width: 200px">Chỉ xem hoá đơn ngày hôm nay</a>
                <a href="/quan-tri/orders/" class="btn btn-block btn-info btn-sm" style="width: 200px; margin-top: 0;">Xem tất cả hoá đơn</a>
                
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
                  <th>Tên người thuê</th>
                  <th>Xe thuê</th>
                  <th>Thời gian thuê</th>
                  <th>Thành tiền</th>
                  <th>Trạng thái xe</th>
                  <th>Trạng thái xử lý</th>
                  <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($orders as $order)
                  <tr>
                    <td>{{ $order->id }}</td>
                    <td><a href="/quan-tri/users/{{ $order->user->id }}">{{ $order->user->ten }}</a></td>
                    <td><a href="/quan-tri/cars/{{ $order->car->id }}/edit">{{ $order->car->ten_hien_thi }}</a></td>
                    <td>Từ {{ $order->bat_dau }} đến {{ $order->ket_thuc }}</td>
                    <td>{{ $order->tong_cong }}</td>
                    <td>{{ $order->car->trang_thai == 0 ? 'Ngừng cho thuê' : 'Sẵn sàng cho thuê' }}</td>
                    <td>{{ $order->trang_thai == 0 ? 'Đang xử lý' : ($order->trang_thai == 1 ? 'Xác nhận' : 'Huỷ') }}</td>
                    <td style="display: flex">
                      <a class="btn btn-block btn-success" style="
                        margin-top: 0;
                      "
                          onclick="event.preventDefault();
                          if (!confirm('Bạn chắc chắn muốn Xác nhận đơn hàng này chứ?')) { return false; };
                          document.getElementById('approved-form-{{ $order->id }}').submit();">
                        Xác nhận
                      </a>
                      <form id="approved-form-{{ $order->id }}" action="/quan-tri/orders/{{ $order->id }}" method="POST" style="display: none;">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                      </form>
                      <a class="btn btn-block btn-danger" style="
                        margin-top: 0;
                      "
                          onclick="event.preventDefault();
                          if (!confirm('Bạn chắc chắn muốn huỷ đơn hàng này chứ?')) { return false; };
                          document.getElementById('rejected-form-{{ $order->id }}').submit();">
                        Ngừng
                      </a>
                      <form id="rejected-form-{{ $order->id }}" action="/quan-tri/orders/{{ $order->id }}" method="POST" style="display: none;">
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
                  <th>Tên người thuê</th>
                  <th>Xe thuê</th>
                  <th>Thời gian thuê</th>
                  <th>Thành tiền</th>
                  <th>Trạng thái</th>
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
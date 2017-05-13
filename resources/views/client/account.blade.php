@extends('layouts.app')
@section('content')
<div class="header_bottom_right_images">
    <div class="content-wrapper">
        <div class="content-top">
            <div class="box_wrapper">
                <h1>Danh sách xe đã thuê</h1>
            </div>
            <div class="text">
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
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên xe</th>
                  <th>Thời gian thuê</th>
                  <th>Thành tiền</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @if ($orders)
                @foreach ($orders as $order)
                  <tr>
                    <td>{{ $order->id }}</td>
                    <td><a href="/xe/{{ $order->car->slug }}-{{ $order->car->id }}">{{ $order->car->name }}</a></td>
                    <td>Từ {{ $order->begin }} đến {{ $order->end }}</td>
                    <td>{{ number_format($order->total, 0, ", ", ".") }} đ</td>
                    <td>{{ $order->status == 0 ? 'Đang xử lý' : ($order->status == 1 ? 'Xác nhận' : 'Huỷ') }}</td>
                    <td style="display: flex">
                      <a class="btn btn-block btn-danger" style="
                        margin-top: 0;
                      "
                          onclick="event.preventDefault();
                          if (!confirm('Bạn chắc chắn muốn huỷ chứ?')) { return false; };
                          document.getElementById('delete-form-{{ $order->id }}').submit();">
                        Xoá
                      </a>
                      <form id="delete-form-{{ $order->id }}" action="/ca-nhan/{{ $order->id }}" method="POST" style="display: none;">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                      </form>
                    </td>
                  </tr>
                @endforeach
                @endif
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Tên xe</th>
                  <th>Thời gian thuê</th>
                  <th>Thành tiền</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
                </tr>
                </tfoot>
              </table>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript" src="/admin/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/plugins/dataTables.bootstrap.min.js"></script>
<script>
  $('#example2').DataTable();
</script>
@endpush
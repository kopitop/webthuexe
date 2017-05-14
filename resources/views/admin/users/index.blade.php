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
                  <th>Tên</th>
                  <th>Email</th>
                  <th>Level</th>
                  <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                  <tr>
                    <td>{{ $user->id }}</td>
                    <td><a href="/quan-tri/users/{{ $user->id }}">{{ $user->ten }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>@if ($user->quyen_han) {{ 'Admin' }} @else {{ 'Member' }} @endif</td>
                    <td style="display: flex">
                      <a href="/quan-tri/users/{{ $user->id }}/edit" class="btn btn-block btn-primary">Sửa</a>
                      <a class="btn btn-block btn-danger" style="
                        margin-top: 0;
                      "
                          onclick="event.preventDefault();
                          if (!confirm('Bạn chắc chắn muốn xoá chứ?')) { return false; };
                          document.getElementById('delete-form-{{ $user->id }}').submit();">
                        Xoá
                      </a>
                      <form id="delete-form-{{ $user->id }}" action="/quan-tri/users/{{ $user->id }}" method="POST" style="display: none;">
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
                  <th>Tên</th>
                  <th>Email</th>
                  <th>Level</th>
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
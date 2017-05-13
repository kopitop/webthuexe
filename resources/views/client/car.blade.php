@extends('layouts.app')
@section('content')
<div class="header_bottom_right_images">
    <div class="about_wrapper">
        <h1>Thông tin chi tiết xe {{ $car->title }}</h1>
    </div>
    <div class="about-group">
        <div class="about-top">
            <div class="grid images_3_of_1">
                <img src="/anh-upload/{{ $car->img }}" alt="">
            </div>
            <div class="grid span_2_of_3">
                {!! $car->desc !!}
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="links">
            <ul>
                <li><a href="#"><img src="/images/blog-icon1.png" title="date"><span>{{ $car->created_at }}</span></a></li>
                <li><a href="#"><img src="/images/blog-icon2.png" title="Admin"><span>{{ $car->category->title }}</span></a></li>
            </ul>
        </div>
        <div class="team">
            <h2>Những xe cùng chủng loại</h2>
            <div class="section group">
                @foreach ($relatedCars->take(3) as $c)
                <div class="grid_1_of_3 images_1_of_3 relatedCar">
                    <img src="/anh-upload/{{ $c->img }}" alt="">
                    <h4><a href="/xe/{{ $c->slug }}-{{ $c->id }}">{{ $c->title }}</a></h4>
                </div>
                @endforeach
                <div class="clear"></div>
            </div>
            <div id="dat-xe"></div>
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
            @if (Auth::user())
            <div class="leave-comment"><a href="#" name="comment">Đặt xe ngay bây giờ</a></div>
            <div class="comments-area">
                <form action="" method="post">
                    <p>
                        <label>Thời gian cần thuê</label>
                        <span>*</span>
                        <input onchange="dateRangeChange()" id="reservation" type="text" value="">
                    </p>
                    <p>
                        <label>Thành tiền</label>
                        <span id="thanh-tien">*</span>
                        <p></p>
                    </p>
                    <p>
                        <form method="post">
                            {{ csrf_field() }}
                            <input id="begin_date" type="hidden" name="begin">
                            <input id="end_date" type="hidden" name="end">
                            <input type="submit">
                        </form>
                    </p>
                    <!-- /.input group -->
                  </div>
                </form>
            </div>
            @else
            <div class="leave-comment"><a href="/login" name="comment">Xin hãy đăng nhập để đặt xe</a></div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('script')
<script type="text/javascript">
    var price = "{{ $car->price }}";

    (function () {
        $('#reservation').daterangepicker();

        Number.prototype.formatMoney = function(c, d, t){
        var n = this, 
            c = isNaN(c = Math.abs(c)) ? 2 : c, 
            d = d == undefined ? "." : d, 
            t = t == undefined ? "," : t, 
            s = n < 0 ? "-" : "", 
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
            j = (j = i.length) > 3 ? j % 3 : 0;

            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
         };
    })();

    function dateRangeChange() {
        if (!$('#reservation').data('daterangepicker')) {
            return false;
        }

        var days = ($('#reservation').data('daterangepicker').endDate._d - $('#reservation').data('daterangepicker').startDate._d)/1000/60/60/24;
        $('#total').val(Math.round(days * price));
        $('#begin_date').val($('#reservation').data('daterangepicker').startDate._d);
        $('#end_date').val($('#reservation').data('daterangepicker').endDate._d);
        $('#thanh-tien').html( Math.round(days * price).formatMoney(2, '.', ',') + ' đồng' );
    }
</script>
@endpush
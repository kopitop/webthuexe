@extends('layouts.app')
@section('content')
<div class="header_bottom_right_images">

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


            <div class="owl-carousel owl-theme">
                @foreach ($randomCars as $car)
                    <div class="item">
                        <a href="/xe/{{ $car->ten_url }}-{{ $car->id }}"><img src="{{ \Storage::url($car->anh) }}" alt="Hình ảnh bị lỗi" ></a>
                    </div>
                @endforeach
            </div>

            <style type="text/css">
                
                .owl-carousel .owl-item img {
                    display: block;
                    height: 500px;
                    width: 100%;
                }

                .owl-nav div {
                    text-decoration: none;
                    display: inline-block;
                    padding: 8px 16px;
                }

                .owl-nav div:hover {
                    background-color: #ddd;
                    cursor: pointer;
                    color: black;
                }

                .owl-nav div.prev {
                    background-color: #4CAF50;
                    color: white;
                }

                .owl-nav div.next {
                    background-color: #4CAF50;
                    color: white;
                    position: relative;
                    left: 85%;
                }

                .owl-nav {
                    position: absolute;
                    top: 50%;
                    width: 100%;
                }

            </style>

    <div class="content-wrapper">
        <div class="content-top">
            <div class="box_wrapper">
                <h1>Xe mới nhất</h1>
            </div>
            <div class="text">
                @foreach ($cars->sortByDesc('created_at')->take(3) as $car)
                <div class="grid_1_of_3 images_1_of_3">
                    <div class="grid_1">
                        <a href="/xe/{{ $car->ten_url }}-{{ $car->id }}"><img style="height:136px" src="{{ \Storage::url($car->anh) }}" title="continue reading" alt=""></a>
                        <div class="grid_desc">
                            <p class="title">{{ $car->ten_hien_thi }}</p>
                            <p class="title1">{{ str_limit($car->gioi_thieu, 50) }}</p>
                            <div class="price">
                                <span class="reducedfrom">{{ number_format($car->gia, 0, ", ", ".") }} đ/ngày</span>
                            </div>
                            <div class="cart-button">
                                <div class="cart">
                                    <a href="#"><img style="width: 20px" src="images/chi-tiet.png" alt=""/></a>
                                </div>
                                <a href="/xe/{{ $car->ten_url }}-{{ $car->id }}#dat-xe" class="button"><span>Đặt xe này</span></a>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                @endforeach
                <div class="clear"></div>
            </div>
        </div>
        <div class="content-top">
            <div class="box_wrapper">
                <h1>Xe rẻ nhất</h1>
            </div>
            <div class="text">
                @foreach ($cars->sortBy('price')->take(3) as $car)
                <div class="grid_1_of_3 images_1_of_3">
                    <div class="grid_1">
                        <a href="/xe/{{ $car->ten_url }}-{{ $car->id }}"><img style="height:136px" src="{{ \Storage::url($car->anh) }}" title="continue reading" alt=""></a>
                        <div class="grid_desc">
                            <p class="title">{{ $car->ten_hien_thi }}</p>
                            <p class="title1">{{ str_limit($car->ten_hien_thi, 50) }}</p>
                            <div class="price">
                                <span class="reducedfrom">{{ number_format($car->gia, 0, ", ", ".") }} đ/ngày</span>
                            </div>
                            <div class="cart-button">
                                <div class="cart">
                                    <a href="#"><img style="width: 20px" src="images/chi-tiet.png" alt=""/></a>
                                </div>
                                <a href="/xe/{{ $car->ten_url }}-{{ $car->id }}#dat-xe" class="button"><span>Đặt xe này</span></a>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                @endforeach
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    $(document).ready(function(){
      $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        },
        navClass: ['prev', 'next']
    })
    });
</script>
@endpush
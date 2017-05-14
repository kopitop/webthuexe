@extends('layouts.app')
@section('content')
<div class="header_bottom_right_images">


            <div class="owl-carousel owl-theme">
                @foreach ($randomCars as $car)
                    <div class="item">
                        <img src="{{ \Storage::url($car->img) }}" alt="Hình ảnh bị lỗi" >
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
                        <a href="/xe/{{ $car->slug }}-{{ $car->id }}"><img style="height:136px" src="{{ \Storage::url($car->img) }}" title="continue reading" alt=""></a>
                        <div class="grid_desc">
                            <p class="title">{{ $car->title }}</p>
                            <p class="title1">{{ str_limit($car->desc, 50) }}</p>
                            <div class="price">
                                <span class="reducedfrom">{{ number_format($car->price, 0, ", ", ".") }} đ/ngày</span>
                            </div>
                            <div class="cart-button">
                                <div class="cart">
                                    <a href="#"><img style="width: 20px" src="images/chi-tiet.png" alt=""/></a>
                                </div>
                                <a href="/xe/{{ $car->slug }}-{{ $car->id }}#dat-xe" class="button"><span>Đặt xe này</span></a>
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
                        <a href="/xe/{{ $car->slug }}-{{ $car->id }}"><img style="height:136px" src="{{ \Storage::url($car->img) }}" title="continue reading" alt=""></a>
                        <div class="grid_desc">
                            <p class="title">{{ $car->title }}</p>
                            <p class="title1">{{ str_limit($car->desc, 50) }}</p>
                            <div class="price">
                                <span class="reducedfrom">{{ number_format($car->price, 0, ", ", ".") }} đ/ngày</span>
                            </div>
                            <div class="cart-button">
                                <div class="cart">
                                    <a href="#"><img style="width: 20px" src="images/chi-tiet.png" alt=""/></a>
                                </div>
                                <a href="/xe/{{ $car->slug }}-{{ $car->id }}#dat-xe" class="button"><span>Đặt xe này</span></a>
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
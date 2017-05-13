@extends('layouts.app')
@section('content')
<div class="header_bottom_right_images">
    <div id="slideshow">
        <ul class="slides">

            @foreach ($randomCars as $car)
            <li>
                <a href="/xe/{{ $car->slug }}-{{ $car->id }}">
                    <canvas ></canvas>
                    <img style="width: 768px" class="img-responsive" src="uploads/{{ $car->img }}" alt="Hình ảnh bị lỗi" >
                </a>
            </li>
            @endforeach

        </ul>
        <span class="arrow previous"></span>
        <span class="arrow next"></span>
    </div>
    <div class="content-wrapper">
        <div class="content-top">
            <div class="box_wrapper">
                <h1>Xe mới nhất</h1>
            </div>
            <div class="text">
                @foreach ($cars->sortByDesc('created_at')->take(3) as $car)
                <div class="grid_1_of_3 images_1_of_3">
                    <div class="grid_1">
                        <a href="/xe/{{ $car->slug }}-{{ $car->id }}"><img style="height:136px" src="uploads/{{ $car->img }}" title="continue reading" alt=""></a>
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
                        <a href="/xe/{{ $car->slug }}-{{ $car->id }}"><img style="height:136px" src="uploads/{{ $car->img }}" title="continue reading" alt=""></a>
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

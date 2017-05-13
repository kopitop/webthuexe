@extends('layouts.app')
@section('content')
<div class="header_bottom_right_images">
    <div class="content-wrapper">
        <div class="content-top">
            <div class="box_wrapper">
                <h1>Xe theo kết quả tìm kiếm</h1>
            </div>
            <div class="text">
                @foreach($carsBySearch as $c)
                <div class="grid_1_of_3 images_1_of_3">
                    <div class="grid_1">
                        <a href="/xe/{{ $c->slug }}-{{ $c->id }}"><img style="height:136px" src="/anh-upload/{{ $c->img }}" title="continue reading" alt=""></a>
                        <div class="grid_desc">
                            <p class="title">{{ $c->title }}</p>
                            <div class="price">
                                <span class="reducedfrom">{{ number_format($c->price, 0, ", ", ".") }} đ/ngày</span>
                            </div>
                            <div class="cart-button">
                                <div class="cart">
                                    <button class="button"><span>Đặt xe này</span></button>
                                </div>
                                <button class="button"><span>Xem</span></button>
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
    <div class="paging">
        {!! $carsBySearch->appends($_GET)->links('vendor.pagination.default', ['paginator' => $carsBySearch]) !!}
    </div>
</div>
@endsection
<!--A Design by W3layouts
    Author: W3layout
    Author URL: http://w3layouts.com
    License: Creative Commons Attribution 3.0 Unported
    License URL: http://creativecommons.org/licenses/by/3.0/
    -->
<!DOCTYPE HTML>
<html>
    <head>
        <title>{{ config('app.name', 'Laravel') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">
        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href='https://fonts.googleapis.com/css?family=Playball' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="header-bg" id="app">
            <div class="wrap">
                <div class="h-bg">
                    <div class="total">
                        <div class="header">
                            <div class="box_header_user_menu">
                                <ul class="user_menu">
                                    <li class="act first">
                                        <a href="">
                                            <div class="button-t"><span>Web cho thuê xe</span></div>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="">
                                            <div class="button-t"><span>Tốt Nhất</span></div>
                                        </a>
                                    </li>
                                    @if (Auth::guest())
                                    <li class="">
                                        <a href="/register">
                                            <div class="button-t"><span>Tạo tài khoản</span></div>
                                        </a>
                                    </li>
                                    <li class="last">
                                        <a href="/login">
                                            <div class="button-t"><span>Đăng nhập</span></div>
                                        </a>
                                    </li>
                                    @else
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            @if (Auth::user()->isAdmin())
                                            <li><a href="{{ config('app.url').'/quan-tri' }}">Đi đến trang Admin</a></li>
                                            @endif
                                            <li><a href="/ca-nhan">Đi đến trang Quản lý tài khoản</a></li>
                                            <li>
                                                <a href="/logout"
                                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                                Logout
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="header-right">
                                <ul class="follow_icon">
                                    <li><a href="#"><img src="/images/Vietnam-Flag.png" alt=""/></a></li>
                                    <li><a href="#"><img src="/images/Icons-Land-Vista-Flags-United-States-Flag-1.ico" alt=""/></a></li>
                                </ul>
                            </div>
                            <div class="clear"></div>
                            <div class="header-bot">
                                <div class="logo">
                                    <a href="/"><img style="width: 250px" src="/images/yesco-logo.png" alt=""/></a>
                                </div>
                                <div class="search">
                                    <form method="GET" action="/xe">
                                        <select name="sort_by">
                                            <option value="title">Tên</option>
                                            <option value="price">Giá</option>
                                        </select>
                                        <select name="asc">
                                            <option value="1" selected="">Tăng dần</option>
                                            <option value="0">Giảm dần</option>
                                        </select>
                                        <input type="text" class="textbox" name="keyword" value="" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}">
                                        <button type="submit" class="gray-button"><span>Tìm kiếm </span></button>
                                    </form>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="menu">
                            <div class="top-nav">
                                <ul>
                                    <li @if($url == 'home' || $url == '') {{ 'class="active"' }} @endif><a href="/">Trang chủ</a></li>
                                    <li @if(preg_match(config('vars.regex.danh-muc-slug'), $url)) {{ "class=active" }} @endif><a href="/danh-muc">Danh mục</a></li>
                                    <li @if(preg_match(config('vars.regex.xe-slug'), $url)) {{ "class=active" }} @endif><a href="/xe">Xe</a></li>
                                </ul>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="banner-top">
                            <div class="header-bottom">
                                @yield('content')
                                <div class="header-para">
                                    <div class="categories">
                                        <div class="list-categories">
                                            @if ($categories->count() >= 2)
                                                @foreach ($categories->random(2) as $category)
                                                <div class="first-list">
                                                    <div class="div_2"><a href="/danh-muc/{{ $category->slug }}-{{$category->id}}">{{ $category->title }}</a></div>
                                                    <div class="div_img">
                                                        <img src="/uploads/{{ $category->cars()->first()->img }}" alt="Cars" title="Cars" width="60" height="39">
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="box">
                                            <div class="box-heading">
                                                <h1><a href="/ca-nhan">Quản lý tài khoản&nbsp;</a></h1>
                                            </div>
                                            <div class="box-content">
                                                Chúc bạn 1 ngày tốt lành&nbsp;<strong></strong>
                                            </div>
                                        </div>
                                        <div class="box-title">
                                            <h1><span class="title-icon"></span><a href="">Quảng Cáo</a></h1>
                                        </div>
                                        <div class="section group example">
                                        @if ($cars->count() >= 4)
                                            <div class="col_1_of_2 span_1_of_2">
                                                @foreach ($cars->random(4) as $car)
                                                    <img src="/uploads/{{ $car->img }}" alt=""/>
                                                @endforeach
                                            </div>
                                            <div class="col_1_of_2 span_1_of_2">
                                                @foreach ($cars->random(4) as $car)
                                                    <img src="/uploads/{{ $car->img }}" alt=""/>
                                                @endforeach
                                            </div>
                                            <div class="clear"></div>
                                        @endif
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                
                                <div class="clear"></div>
                                <div class="footer-bottom">
                                    <div class="copy">
                                        <p>All rights Reserved | Design by <a href="#">WebThueXe</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scripts -->
	    <script src="{{ asset('js/app.js') }}"></script>
        @stack('script')
    </body>
</html>
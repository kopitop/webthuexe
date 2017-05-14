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
                                        {{ Auth::user()->ten }} <span class="caret"></span>
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
                                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
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
                                            <option @if($oldInput && ($oldInput['sort_by'] == 'ten_hien_thi')) {{ 'selected' }} @endif value="ten_hien_thi">Tên</option>
                                            <option @if($oldInput && ($oldInput['sort_by'] == 'gia')) {{ 'selected' }} @endif value="gia">Giá</option>
                                        </select>
                                        <select name="asc">
                                            <option @if($oldInput && $oldInput['asc']) {{ 'selected' }} @endif value="1" selected="">Tăng dần</option>
                                            <option @if($oldInput && !$oldInput['asc']) {{ 'selected' }} @endif value="0">Giảm dần</option>
                                        </select>
                                        <input type="text" class="textbox" name="keyword" value="@if($oldInput && $oldInput['keyword']) {{ $oldInput['keyword'] }} @endif" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}">
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

                                    @foreach ($categories as $category)

                                    @if ($category->danh_muc_cha_id === 0)
                                    <li><a href="/danh-muc/{{ $category->ten_url }}-{{ $category->id }}">{{ $category->ten_hien_thi }}</a></li>

                                    @endif
                                    @endforeach
                                    <li @if(preg_match(config('vars.regex.danh-muc-slug'), $url)) {{ "class=active" }} @endif><a href="/danh-muc">Tất Ca</a></li>
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
                                            @if ($categories->count() >= 5)
                                                @foreach ($categories->random(5) as $category)
                                                <div class="first-list">
                                                    <div class="div_2"><a href="/danh-muc/{{ $category->ten_url }}-{{$category->id}}">{{ $category->ten_hien_thi }}</a></div>
                                                    <div class="div_img">
                                                        @if ($category->cars->count() >= 1)
                                                        <img src="@if (property_exists($category->cars->take(1), 'img')) {{ \Storage::url($category->cars->random(1)->anh) }}" @endif alt="Cars" title="Cars" width="60" height="39">

                                                        @endif
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                @endforeach
                                            @else
                                                @foreach ($categories as $category)
                                                    <div class="first-list">
                                                        <div class="div_2"><a href="/danh-muc/{{ $category->ten_url }}-{{$category->id}}">{{ $category->ten_hien_thi }}</a></div>
                                                        <div class="div_img">
                                                            @if ($category->cars->count() >= 1)
                                                            <img src="@if (property_exists($category->cars->take(1), 'img')) {{ \Storage::url($category->cars->take(1)->anh) }}" @endif alt="Cars" title="Cars" width="60" height="39">
                                                            @endif
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
                                        <!-- @if ($cars->count() >= 4)
                                            <div class="col_1_of_2 span_1_of_2">
                                                @foreach ($cars->random(4) as $car)
                                                    <img src="{{ \Storage::url($car->anh) }}" alt=""/>
                                                @endforeach
                                            </div>
                                            <div class="col_1_of_2 span_1_of_2">
                                                @foreach ($cars->random(4) as $car)
                                                    <img src="{{ \Storage::url($car->anh) }}" alt=""/>
                                                @endforeach
                                            </div>
                                            <div class="clear"></div>
                                        @endif -->
                                        <img src="http://trungtamgoogle.com/wp-content/uploads/2015/09/quangcao.png">
                                        <img src="http://www.alaskayouthsoccer.org/imagedata/17_Advertise_with_us.png">
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                
                                <div class="clear"></div>
                                <div class="footer-bottom">
                                    <div id="zt-footer" class="clearfix pattern0">
                
                    <div id="zt-footer-inner" class="row-fluid">
                        <div class="col-md-6" style="padding:0 10px;">
                                


<div id="k2ModuleBox96" class="k2ItemsBlock">






       

        
        <p><strong>CÔNG TY CHO THUÊ XE CHUYÊN NGHIỆP</strong></p>
<p>Địa chỉ: 999 Trương Định, Hoàng Mai, Hà Nội</p>
<p>Điện thoại: <a href="tel:99999999">(04)99999999</a> - <a href="tel:043736978">(04)99999999</a></p>
<p>Hotline: <a href="tel:99999999">(04)3 99999999</a> - <a href="tel:0913534623">99999999</a></p>
<p>Email: <span id="cloak5820"><a href="https://www.facebook.com/bang.long.300">Băng Long</a></span><script type="text/javascript">
 //<!--
 document.getElementById('cloak5820').innerHTML = '';
 var prefix = '&#109;a' + 'i&#108;' + '&#116;o';
 var path = 'hr' + 'ef' + '=';
 document.getElementById('cloak5820').innerHTML += '<a ' + path + '\'' + prefix + ':' + 'banglong@gmail.com' + '\'>' + 'Băng Long' +'<\/a>';
 //-->
 </script></p>
        
    







</div>



                            <div class="clearfix"></div>
                        </div>
                        
                           <div class="span4 hidden-phone" style="float:right; text-align:right; padding-right:10px;">
                                


<div id="k2ModuleBox216" class="k2ItemsBlock">






       

        
        <p>Liên kết:&nbsp;<select style="width: 170px;" onchange="window.open(this.value, '_blank');"><option value="https://www.facebook.com/bang.long.300">Website Thuê Xe</option><option value="https://www.facebook.com/bang.long.300">Website Thuê Xe</option><option value="https://www.facebook.com/bang.long.300">Website Thuê Xe</option><option value="http://www.facebook.com/">Website Thuê Xe</option><option value="https://www.facebook.com/bang.long.300">Website Thuê Xe</option></select></p><a href="https://www.facebook.com/bang.long.300" target="_blank">Băng </a>
        
    







</div>

<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&width=450&layout=standard&action=like&size=small&show_faces=true&share=true&height=80&appId=242624119487336" width="450" height="80" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>

                            <div class="clearfix"></div>
                        </div>
                    </div>
            
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
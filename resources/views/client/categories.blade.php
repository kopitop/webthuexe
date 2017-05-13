@extends('layouts.app')
@section('content')
<div class="header_bottom_right_images">
    <div class="content-wrapper">
        <div class="content-top">
            <div class="box_wrapper">
                <h1>Tất cả danh mục</h1>
            </div>
            <div class="text">
            <div id="menu">
                {!! $nestedCategories->renderAsHtml() !!}
            </div>
            <style type="text/css">
            #menu>ul a:link, #menu>ul a:active, #menu>ul a:visited{
                display:block;
                padding:10px 25px;
                border:1px solid #333;
                color:#fff;
                text-decoration:none;
                background-color:#333;
            }
            #menu>ul a:hover{
                background-color:#fff;
                color:#333;
            }
            #menu>ul li{
                float:left;
                position:relative;
            }
            #menu>ul ul {
                position:absolute;
                width:12em;
                top:2em;
                display:none;
            }
            #menu>ul li ul a{
                width:12em;
                float:left;
            }
            #menu>ul ul ul{
            top:auto;
            }

            #menu>ul li ul ul {
            left:12em;
            margin:0px 0 0 10px;
            }

            #menu>ul li:hover ul ul, #menu>ul li:hover ul ul ul, #menu>ul li:hover ul ul ul ul{
            display:none;
            }
            #menu>ul li:hover ul, #menu>ul li li:hover ul, #menu>ul li li li:hover ul, #menu>ul li li li li:hover ul{
            display:block;
            }
            </style>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="paging">

    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    function mainmenu(){
    $(" #menu>ul ul ").css({display: "none"}); // Opera Fix
    $(" #menu>ul li").hover(function(){
        $(this).find('ul:first').css({visibility: "visible",display: "none"}).show(400);
        },function(){
        $(this).find('ul:first').css({visibility: "hidden"});
        });
    }

    $(document).ready(function(){
        mainmenu();
    });
</script>
@endpush
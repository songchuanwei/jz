<!DOCTYPE html>
<html>

<head>
    <title>绑定小记者账号</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <link rel="stylesheet" href="/css/weui.min.css">
    <link rel="stylesheet" href="/css/jquery-weui.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    body, html {
        height: 100%;
        -webkit-tap-highlight-color: transparent;
        background-color: #ffffff;
    }
</style>
<body ontouchstart>
<header class='demos-header' style="  display: flex;
        justify-content: center;
        align-items: center;  ">
    <img style="height: 150px; vertical-align:middle; margin: 30px 0 10px 0" src="/images/jz.jpg">
</header>

<form method="post" action="/user/login">
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" name="name_login" id="name_login" value="{{ old('name_login') }}" placeholder="请输入姓名" style="font-size: 13px;">
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd"><label class="weui-label">小记者编号</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="number" name="num" id="num" value="{{ old('num') }}" placeholder="请输入小记者编号" style="font-size: 13px;">
            </div>
        </div>

        {{ csrf_field() }}

        <div class="weui-btn-area">
            <button class="weui-btn weui-btn_primary" id="login">确认绑定</button>
        </div>
        <div class="weui-btn-area">
            <a href="/user/register" class="weui-btn weui-btn_plain-default">注册新账号</a>
        </div>
    </div>
</form>

<div class="weui-footer" style="margin-top: 10px">
    <p class="weui-footer__text">提示：如果没有有小记者编号，请先点击上方注册新账号</p>
</div>

    <script src="/js/jquery-2.1.4.js"></script>
    <script src="/js/jquery-weui.min.js"></script>

    <!-- 如果使用了某些拓展插件还需要额外的JS -->
    <script src="/js/swiper.min.js"></script>
<script src="/js/city-picker.min.js"></script>

    <script>

        $("#login").click(function() {
            var name_login = $('#name_login').val();
            var num=$('#num').val();
            if(!name_login){
                $.alert('请输入姓名');
                return false;
            }
            else if(!num){
                $.alert('请输入小记者编号');
                return false;
            }

        });


        @if (session('success'))
        $.alert("{{session('success')}}");
        @endif
        @if (session('error'))
        $.alert("{{session('error')}}");
        @endif

    </script>
</body>

</html>
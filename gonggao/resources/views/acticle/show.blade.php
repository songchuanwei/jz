<!DOCTYPE html>
<html>

<head>
    <title>我要投稿</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <link rel="stylesheet" type="text/css" href="/css/aui.css" />
    <link rel="stylesheet" href="/css/weui.min.css">
    <link rel="stylesheet" href="/css/jquery-weui.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    body, html {
        height: 100%;
        -webkit-tap-highlight-color: transparent;
    }
    .swiper-container {
        width: 100%;
    }

    .swiper-container img {
        display: block;
        width: 100%;
    }
    .demos-title {
        text-align: center;
        font-size: 20px;
        font-weight: 400;
    }

    .demos-sub-title {
        text-align: center;
        color: #888;
        font-size: 14px;
    }

    .demos-header {
        padding: 10px 0;
        background-color: #ffffff;
    }

    .demos-content-padded {
        padding: 15px;
    }

    .demos-second-title {
        text-align: center;
        font-size: 24px;
        color: #3cc51f;
        font-weight: 400;
    }
</style>

<body ontouchstart>

<header class='demos-header'>
    <h3 class="demos-title"><b>{{$acticle->title}}</b></h3>
</header>
<div class="aui-content aui-margin-b-15">
    <ul class="aui-list aui-media-list">
        <li class="aui-list-item" style="background-color: #ffffff">
            <div class="aui-list-item-inner">
                <p>&nbsp;&nbsp;&nbsp;&nbsp;{{$acticle->content}}</p>
                <div class="aui-row aui-row-padded">
                    @foreach(explode(",", $acticle->photo) as $k=>$v)
                        @if($k<count(explode(",", $acticle->photo))-1)
                            <div class="aui-col-xs-4">
                                <img src="{{$v}}" onclick="image('{{$v}}')"/>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </li>
        <li class="aui-list-item" style="background-color: #ffffff">
            @if($acticle->review)
                <div class="aui-media-list-item-inner">
                    <div class="aui-list-item-inner">
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title">已审阅</div>
                        </div>
                        <div class="aui-list-item-text aui-ellipsis-2">
                            &nbsp;&nbsp;&nbsp;&nbsp;{{$acticle->review}}
                        </div>
                    </div>
                </div>
            @else
                <div class="aui-media-list-item-inner">
                    <div class="aui-list-item-inner">
                        <div class="aui-list-item-text">
                            <div class="aui-list-item-title">未审阅</div>
                        </div>
                    </div>
                </div>
            @endif

        </li>
    </ul>
</div>


<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>
<script src="/js/swiper.js"></script>

<script>

    function image(img){
        var pb1 = $.photoBrowser({
            items: [
                img
            ]
        });
        pb1.open(2);
    }
    @if (session('success'))
    $.toptip("{{session('success')}}", 2000, 'success');  //设置显示时间
    @endif
    @if (session('error'))
    $.toptip("{{session('error')}}", 2000, 'error');  //设置显示时间
    @endif

</script>


</body>

</html>
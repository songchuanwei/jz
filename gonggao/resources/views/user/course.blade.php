<!DOCTYPE html>
<html>

<head>
    <title>小记者</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <link rel="stylesheet" href="/css/weui.min.css">
    <link rel="stylesheet" href="/css/jquery-weui.min.css">
</head>
<style>
    body, html {
        height: 100%;
        -webkit-tap-highlight-color: transparent;
    }
</style>

<body ontouchstart>

<div class="weui-tab">

    <div class="weui-panel" style="margin: 0 0 50px 0">

        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__hd">我参加的课程</div>
            <div class="weui-panel__ft">
                @foreach($jz->Courses()->get() as $count)
                    <a href="/course/show?id={{$count->id}}" class="weui-cell weui-cell_access weui-cell_link">
                        <div class="weui-cell__bd">《 {{$count->name}} 》 <br><p class="weui-media-box__desc">授课教师：{{$count->teacher}}</p></div>
                        <span class="weui-cell__ft"></span>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
    <div class="weui-loadmore weui-loadmore_line">
        <span class="weui-loadmore__tips">没有更多了</span>
    </div>

    <a class="weui-btn weui-btn_primary" onclick="javascript:history.back(-1);">返回</a>


</div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>

<!-- 如果使用了某些拓展插件还需要额外的JS -->
<script src="/js/swiper.min.js"></script>
<script src="/js/city-picker.min.js"></script>

<script>

</script>


</body>

</html>
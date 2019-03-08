<!DOCTYPE html>
<html>

<head>
    <title>小记者</title>
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
    }
</style>

<body ontouchstart>
<h3 style="text-align: center;margin: 20px 0 20px 0;">我的总积分：<b style="color: red;">{{$acticles->sum('point')+$activitys->sum('point')+$courses->sum('point')}}</b></h3>
<div class="weui-panel" style="margin: 0 0 50px 0">

    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd">我参加的活动</div>
        @foreach($activitys as $v)
                <div class="weui-panel__bd">
                    <div class="weui-media-box weui-media-box_text">
                        <h3 class="weui-media-box__title">{{mb_substr($v->name,0,15)}}...
                            @if(strtotime($v->end_time) < time())
                            <a href="/activity/list?id={{$v->id}}" class="weui-btn weui-btn_mini weui-btn_plain-default" style="float: right">现场花絮</a>
                            @else
                                <button class="weui-btn weui-btn_mini weui-btn_plain-default" style="float: right">还未开始</>
                            @endif
                        </h3>
                        <ul class="weui-media-box__info">
                            <li class="weui-media-box__info__meta">积分：{{$v->point}}</li>
                        </ul>
                    </div>
                </div>
        @endforeach
    </div>

    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd">我参加的课程</div>
        <div class="weui-panel__ft">
            @foreach($courses as $count)
                <a href="/course/show?id={{$count->id}}" class="weui-cell weui-cell_access weui-cell_link">
                    <div class="weui-cell__bd">《 {{$count->name}} 》 <br><p class="weui-media-box__desc">积分：{{$count->point}}</p></div>
                    <span class="weui-cell__ft"></span>
                </a>
            @endforeach
        </div>
    </div>

    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd">我的投稿</div>
        <div class="weui-panel__ft">
            @foreach($acticles as $acticle)
                <a href="#" class="weui-cell weui-cell_access weui-cell_link">
                    <div class="weui-cell__bd">{{mb_substr($acticle->title,0,15)}}... <br><p class="weui-media-box__desc">积分：{{$acticle->point}}</p></div>
                </a>
            @endforeach
        </div>
    </div>

</div>
<div class="weui-loadmore weui-loadmore_line">
    <span class="weui-loadmore__tips">没有更多了</span>
</div>
<a class="weui-btn weui-btn_primary" onclick="javascript:history.back(-1);">返回</a>


<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>

<!-- 如果使用了某些拓展插件还需要额外的JS -->
<script src="/js/swiper.min.js"></script>
<script src="/js/city-picker.min.js"></script>

<script>


</script>


</body>

</html>
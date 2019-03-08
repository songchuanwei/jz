<!DOCTYPE html>
<html>

<head>
    <title>小记者活动</title>
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
    .swiper-container {
        width: 100%;
    }

    .swiper-container img {
        display: block;
        width: 100%;
    }
    .weui-media-box__info{
        margin-top: -3px;
    }
    .weui-media-box__info{
        color: #708691;
        font-size: 14px;
    }

    .weui-panel:after, .weui-panel:before{
        position:relative;
    }
    .weui-panel__bd{
        border-bottom: 1px double #eeeeee;
        margin: 0 20px 0 20px;
    }
    .weui-media-box{
        margin: 0 -20px 0 -20px;
    }
</style>

<body ontouchstart>

<div class="weui-tab">
    <div class="weui-tabbar">
        <a href="/activity/index" class="weui-tabbar__item weui-bar__item--on">
            <span class="weui-badge" style="position: absolute;top: -.4em;right: 1em;">{{$activitys->count()}}</span>
            <div class="weui-tabbar__icon">
                <img src="/images/activity1.png">
            </div>
            <p class="weui-tabbar__label">小记者活动</p>
        </a>
        <a href="/course/index" class="weui-tabbar__item">
            <div class="weui-tabbar__icon">
                <img src="/images/course.png" alt="">
            </div>
            <p class="weui-tabbar__label">核心素养课</p>
        </a>
        <a href="/acticle/index" class="weui-tabbar__item">
            <div class="weui-tabbar__icon">
                <img src="/images/acticle.png" alt="">
            </div>
            <p class="weui-tabbar__label">我要投稿</p>
        </a>
        <a href="/user/index" class="weui-tabbar__item">
            <div class="weui-tabbar__icon">
                <img src="/images/user.png" alt="">
            </div>
            <p class="weui-tabbar__label">个人中心</p>
        </a>
    </div>

    <div class="weui-tab__bd">
        <div id="tab1" class="weui-tab__bd-item weui-tab__bd-item--active">

            <div class="weui-panel" style="margin: 0 0 50px 0">
                <div class="weui-cells__title" style="color: #000000; border-bottom: 1px double #000000; font-size: 20px;margin-left: -15px;"><b>近期活动</b></div>
                @foreach($activitys as $activity)
                    @if(strtotime($activity->start_time) > time())
                        <div class="weui-panel__bd" onclick="window.location.href='/activity/show?id={{$activity->id}}'">
                            <div class="weui-media-box weui-media-box_text">
                                <h3 class="weui-media-box__title"><img src="/images/jinqi.png" style="height: 18px; width: 18px;"/>&nbsp;&nbsp;{{mb_substr($activity->name,0,10)}}... &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 14px; color: orangered; ">
                                        @if($activity->money==0)
                                            免费
                                        @else
                                            ￥ {{$activity->money}}
                                        @endif
                                    </span>
                                @if($activity->num==$activity->limit)
                                    <a href="#" class="weui-btn weui-btn_mini weui-btn_disabled weui-btn_primary" style="float: right">人数已满</a>
                                    @else
                                    <a href="/activity/show?id={{$activity->id}}" class="weui-btn weui-btn_mini weui-btn_primary" style="float: right">参加</a>
                                @endif
                                </h3>
                                <ul class="weui-media-box__info">
                                    <li class="weui-media-box__info__meta">活动时间：{{date("Y.m.d H:i",strtotime($activity->start_time))}} ~ {{date("Y.m.d H:i",strtotime($activity->end_time))}}</li>
                                </ul>
                                <ul class="weui-media-box__info">
                                    <li class="weui-media-box__info__meta">活动人数</li>
                                    <li>
                                        <div class="weui-progress">
                                            {{$activity->num1?$activity->num1:0}}&nbsp;&nbsp;<div class="weui-progress__bar">
                                                <div class="weui-progress__inner-bar js_progress" style="width:{{($activity->num1/$activity->limit)*100}}%;"></div>
                                            </div>&nbsp;&nbsp;{{$activity->limit}}
                                        </div>
                                    </li>
                                </ul>
                                <ul class="weui-media-box__info">
                                    <li class="weui-media-box__info__meta">活动地点：{{$activity->start_location}}</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="weui-cells__title" style="color: #000000; border-bottom: 1px double #000000; font-size: 20px;margin-left: -15px;"><b>正在进行</b></div>
                @foreach($activitys as $activity)
                    @if(strtotime($activity->start_time) <= time() && strtotime($activity->end_time) >= time())
                        <div class="weui-panel__bd"  onclick="window.location.href='/activity/list?id={{$activity->id}}'">
                            <div class="weui-media-box weui-media-box_text" >
                                <h3 class="weui-media-box__title"><img src="/images/zhengzai.png" style="height: 18px; width: 18px;"/>&nbsp;&nbsp;{{mb_substr($activity->name,0,15)}}...<a href="/activity/list?id={{$activity->id}}" class="weui-btn weui-btn_mini weui-btn_primary" style="float: right">现场</a></h3>
                                <ul class="weui-media-box__info">
                                    <li class="weui-media-box__info__meta">活动时间：{{date("Y.m.d H:i",strtotime($activity->start_time))}} ~ {{date("Y.m.d H:i",strtotime($activity->end_time))}}</li>
                                </ul>
                                <ul class="weui-media-box__info">
                                    <li class="weui-media-box__info__meta">活动地点：{{$activity->start_location}}</li>
                                </ul>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>

    </div>

</div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>

<script>
    @if (session('success'))
    if("{{session('success')}}"=='小记者注册成功'){
        $.modal({
            title: "成为会员?",
            text: "只有缴费的会员才能参加活动和公开课。",
            buttons: [
                { text: "现在缴费", onClick: function(){
                        location.href='/activity/vip?id={{$jz->id}}';
                    } },
                { text: "随后在说", onClick: function(){
                        $.toptip("取消成为会员", 2000, 'error');  //设置显示时间
                    } }
            ]
        });
    }
    @endif
    @if (session('error'))
    $.toptip("{{session('error')}}", 2000, 'error');  //设置显示时间
    @endif

</script>


</body>

</html>
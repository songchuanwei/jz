<!DOCTYPE html>
<html>

<head>
    <title>核心素养课</title>
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
    .swiper-container {
        width: 100%;
    }

    .swiper-container img {
        display: block;
        width: 100%;
    }
</style>

<body ontouchstart>

<div class="weui-tab">
    <div class="weui-tabbar">
        <a href="/activity/index" class="weui-tabbar__item">
            <span class="weui-badge" style="position: absolute;top: -.4em;right: 1em;">{{$activitys->count()}}</span>
            <div class="weui-tabbar__icon">
                <img src="/images/activity.png" alt="">
            </div>
            <p class="weui-tabbar__label">小记者活动</p>
        </a>
        <a href="#tab2" class="weui-tabbar__item weui-bar__item--on">
            <div class="weui-tabbar__icon">
                <img src="/images/course1.png" alt="">
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

        <div id="tab2" class="weui-tab__bd-item weui-tab__bd-item--active">
            {{--<div class="swiper-container">--}}
                {{--<!-- Additional required wrapper -->--}}
                {{--<div class="swiper-wrapper">--}}
                    {{--<div class="swiper-slide"><img src="https://ss2.bdstatic.com/70cFvnSh_Q1YnxGkpoWK1HF6hhy/it/u=1034485995,908069195&fm=26&gp=0.jpg" height="200px"></div>--}}
                    {{--<div class="swiper-slide"><img src="https://ss1.bdstatic.com/70cFuXSh_Q1YnxGkpoWK1HF6hhy/it/u=1576944942,170483903&fm=26&gp=0.jpg" height="200px"></div>--}}
                    {{--<div class="swiper-slide"><img src="https://ss0.bdstatic.com/70cFuHSh_Q1YnxGkpoWK1HF6hhy/it/u=2168862102,3045817142&fm=26&gp=0.jpg" height="200px"></div>--}}
                {{--</div>--}}
                {{--<!-- If we need pagination -->--}}
                {{--<div class="swiper-pagination"></div>--}}
            {{--</div>--}}

            <img src="/images/gongkaike.png" width="100%" height="200px" style="background-color: #ffffff;">
            <div class="page__bd" style="margin: 0 0 100px 0">
                <div class="weui-panel weui-panel_access">
                    <div class="weui-panel__bd">
                        @foreach($courses as $course)
                            <a href="/course/show?id={{$course->id}}" class="weui-media-box weui-media-box_appmsg">
                                <div class="weui-media-box__hd" style="width: 90px; height: 90px;">
                                    <img class="weui-media-box__thumb" src="{{$course->photo}}">
                                </div>
                                <div class="weui-media-box__bd">
                                    <h4 class="weui-media-box__title">《{{$course->name}}》</h4>
                                    <p class="weui-media-box__desc">老师：{{$course->teacher}}</p>
                                    <p class="weui-media-box__desc">面向年级：{{$course->grade}}</p>
                                    <p class="weui-media-box__desc">课程人数：{{$course->num1}}/{{$course->limit}}</p>
                                    <p class="weui-media-box__desc">开课时间：<span style="color:red;">{{date("Y.m.d H:i",strtotime($course->time))}}</span></p>
                                </div>
                            </a>
                        @endforeach
                        @if($courses->count()==0)
                            管理员未发布公开课
                            @endif
                    </div>
                </div>
            </div>


        </div>
    </div>

</div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>

<!-- 如果使用了某些拓展插件还需要额外的JS -->
<script src="/js/swiper.js"></script>
<script>
    $(".swiper-container").swiper({
        loop: true,
    });
</script>

<script>

    @if (session('success'))
    $.toptip("{{session('success')}}", 2000, 'success');  //设置显示时间
    @endif
    @if (session('error'))
    $.toptip("{{session('error')}}", 2000, 'error');  //设置显示时间
    @endif

</script>


</body>

</html>
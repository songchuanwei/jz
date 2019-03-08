<!DOCTYPE html>
<html>

<head>
    <title>核心素养课详情</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/weui.min.css">
    <link rel="stylesheet" href="/css/jquery-weui.min.css">
</head>
<style>
    body, html {
        height: 95%;
        -webkit-tap-highlight-color: transparent;
    }
</style>

<body ontouchstart>

<div class="page__bd" style="margin: 30px 0 30px 0">
    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__bd">
            <a href="#" class="weui-media-box weui-media-box_appmsg">
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
        </div>
    </div>
</div>
    <article class="weui-article" style="background-color: #ffffff">
        <h1>详细信息：</h1>
        <section>
            <section>
                <div style="margin: 0 0 0 20px;">
                    <h3>课程积分：<span class="weui-msg__desc">{{$course->point}}</span></h3>
                    <h3>上课地点：<span class="weui-msg__desc">{{$course->location}}</span></h3>
                    <h3>课程介绍：<span class="weui-msg__desc">{{$course->content}}</span></h3>
                    <h3>老师介绍：<span class="weui-msg__desc">{{$course->teacher_info}}asdfasdfasfasfasf</span></h3>
                </div>
            </section>
        </section>
    </article>

    <div class="weui-msg__opr-area">
        <p class="weui-btn-area">
            @if($countCourse>=1)
                <button class="weui-btn weui-btn_plain-primary">每人最多参加一门课程</button>
            @else
                <button onclick="btn()" class="weui-btn weui-btn_primary">参加课程</button>
            @endif
        </p>
    </div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>

<!-- 如果使用了某些拓展插件还需要额外的JS -->
<script src="/js/swiper.min.js"></script>
<script src="/js/city-picker.min.js"></script>

<script>

    function btn(){
        @if($jz->vip_type==1)
        $.confirm({
            title: '参加核心素养课?',
            text: '每个小记者只能参加一门课程，请考虑清楚。',
            onOK: function () {
                $.ajax({
                    type: 'get',
                    url: '/course/join?user_id={{$jz->id}}&course_id={{$course->id}}',
                    success: function(data){
                        if(data.error ==0 ){
                            $.toptip(data.msg, 2000, 'success');  //设置显示时间
                            parent.location.reload();
                        }else{
                            $.toptip(data.msg, 2000, 'error');  //设置显示时间
                        }
                    }
                });
            }
        });
        @else
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
        @endif
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
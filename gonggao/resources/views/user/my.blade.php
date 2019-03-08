<!DOCTYPE html>
<html>

<head>
    <title>个人信息</title>
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

<header class='demos-header' style="  display: flex;
    justify-content: center;
    align-items: center;
    margin: 40px 0 30px 0">
    <img style="width: 150px;height: 150px;" src="{{$jz->photo}}">
</header>

<div class="weui-form-preview">
    <div class="weui-form-preview__hd">
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">姓名：</label>
            <span>{{$jz->name}}</span>
        </div>
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">身份证号：</label>
            <span>
                @if(empty($jz->card))
                    未填写身份证号
                @else
                    {{$jz->card}}
                @endif
            </span>
        </div>
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">小记者编号：</label>
            <span>
                @if($jz->vip_type==0)
                    请先成为会员
                @else
                    {{$jz->num}}
                @endif
            </span>
        </div>
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">家长手机号：</label>
            <span>{{$jz->phone}}</span>
        </div>
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">学校/年级/班级：</label>
            <span>{{$jz->school}}&nbsp{{$jz->grade}}&nbsp{{$jz->class}}</span>
        </div>
        <div class="weui-form-preview__item">
            <label class="weui-form-preview__label">手机号：</label>
            <span>{{$jz->phone}}</span>
        </div>
    </div>
</div>

@if($jz->vip_type==0)
    <a href="/activity/vip?id={{$jz->id}}" class="weui-btn weui-btn_primary" style="margin: 0 0 10px 0">成为会员</a>
@endif
<a class="weui-btn weui-btn_plain-default" href="/user/edit?id={{$jz->id}}" style="margin: 0 0 20px 0">编辑信息</a>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>

<!-- 如果使用了某些拓展插件还需要额外的JS -->
<script src="/js/swiper.min.js"></script>
<script src="/js/city-picker.min.js"></script>

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
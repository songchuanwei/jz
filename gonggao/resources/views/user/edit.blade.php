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
    .weui-cells:before,.weui-cells:after{
        position: relative;
        line-height: 10px;
    }
    .sex{
        margin-top: 0;
    }
    .sex_label{
        padding: 0 10px;
    }
    body,
    html {
        height: 100%;
        -webkit-tap-highlight-color: transparent;
    }

    .demos-title {
        text-align: center;
        font-size: 27px;
        color: #3cc51f;
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
        padding: 15px 0 35px 0;
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
    <h3 class="demos-title">个人信息</h3>
</header>

<div id="tab2" class="weui-tab__bd-item" style="margin: -20px 0 0 0">
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
                <div class="weui-cell__bd">
                    {{$jz->name}}
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">身份证号</label></div>
                <div class="weui-cell__bd">
                    {{$jz->card}}
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">性别</label></div>
                <div class="weui-cell__bd">
                    {{$jz->card=='男'?'男':'女'}}
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">年龄</label></div>
                <div class="weui-cell__bd">
                    {{$jz->age}}
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">学校/班级</label></div>
                <div class="weui-cell__bd">
                    {{$jz->school}} {{$jz->grade}} {{$jz->class}}
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">联系电话</label></div>
                <div class="weui-cell__bd">
                    {{$jz->phone}}
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <div class="weui-uploader">
                        <div class="weui-uploader__hd">
                            <p class="weui-uploader__title">个人头像</p>
                            <div class="weui-uploader__info" id="num"></div>
                        </div>
                        <div class="weui-uploader__bd">
                            <ul class="weui-uploader__files" id="uploaderFiles">
                                <img class='weui-uploader__file' src='{{$jz->photo}}'>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="photo" value="{{$jz->photo}}" id="card_url">
            <input type="hidden" name="user_id" value="{{$jz->id}}">
            {{ csrf_field() }}

            <div class="weui-btn-area">
                <button class="weui-btn weui-btn_primary" onclick="javascript:history.back(-1);">返回</button>
            </div>
        </div>
</div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>

<!-- 如果使用了某些拓展插件还需要额外的JS -->
<script src="/js/swiper.min.js"></script>
<script src="/js/city-picker.min.js"></script>

<script>

    @if (session('success'))
    $.alert("{{session('success')}}");
    @endif
    @if (session('error'))
    $.alert("{{session('error')}}");
    @endif

</script>
</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <title>我要投稿</title>
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

<div class="weui-tab" id="view">
    <div class="weui-tabbar">
        <a href="/activity/index" class="weui-tabbar__item">
            <span class="weui-badge" style="position: absolute;top: -.4em;right: 1em;">{{$activitys->count()}}</span>
            <div class="weui-tabbar__icon">
                <img src="/images/activity.png" alt="">
            </div>
            <p class="weui-tabbar__label">小记者活动</p>
        </a>
        <a href="/course/index" class="weui-tabbar__item">
            <div class="weui-tabbar__icon">
                <img src="/images/course.png" alt="">
            </div>
            <p class="weui-tabbar__label">核心素养课</p>
        </a>
        <a href="#tab3" class="weui-tabbar__item weui-bar__item--on">
            <div class="weui-tabbar__icon">
                <img src="/images/acticle1.png" alt="">
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

        <div id="tab3" class="weui-tab__bd-item weui-tab__bd-item--active">

            <form method="post" action="/acticle/create" enctype ="multipart/form-data" style="margin: 30px 0 50px 0">
                <div class="weui-cells weui-cells_form">
                    <div class="weui-cell">
                        <div class="weui-cell__hd"><label class="weui-label">稿件题目</label></div>
                        <div class="weui-cell__bd">
                            <input class="weui-input" type="text" name="title" id="title" value="" placeholder="请输入稿件题目" style="font-size: 13px;">
                        </div>
                    </div>


                    <div class="weui-cell" style="position:relative;">
                        <span>稿件内容</span>
                    </div>
                    <div class="weui-cell">
                        <div class="weui-cell__bd" style="border: 1px dashed #eeeeee">
                            <textarea class="weui-textarea" name="content" id="content" placeholder="请输入文本" rows="15" style="font-size: 13px;"></textarea>
                            <div class="weui-textarea-counter">500</div>
                        </div>
                    </div>

                    <div class="weui-cell">
                        <div class="weui-cell__bd">
                            <div class="weui-uploader">
                                <div class="weui-uploader__hd">
                                    <p class="weui-uploader__title">上传图片</p>
                                    <div class="weui-uploader__info" id="num" style="font-size: 13px;">可传多张</div>
                                </div>
                                <div class="weui-uploader__bd">
                                    <ul class="weui-uploader__files" id="uploaderFiles">
                                    </ul>
                                    <div class="weui-uploader__input-box" id="weui-uploader__input-box1">
                                        <input  type="file" accept="image/*" style="display: none;" multiple="">
                                        <div id="uploaderInput" class="weui-uploader__input"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="photo" value="" id="card_url">
                    {{ csrf_field() }}

                    <div class="weui-btn-area">
                        <button class="weui-btn weui-btn_primary" id="btn">提交</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

</div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config({!! $js->config(array('chooseImage','uploadImage','downloadImage'),false)  !!});
</script>

<script>

    window.onload=function () {
        var load=document.body.clientHeight;
        var view=document.getElementById("view");
        view.style.height=load+'px';
    };


    $("#btn").click(function() {
        var title = $('#title').val();
        var content=$('#content').val();
        if(!title && title.length<=50){
            $.alert('请正确输入稿件标题');
            return false;
        }
        else if(!content && content.length<=500){
            $.alert('请正确输入标题内容');
            return false;
        }

    });

    var photos='';
    $("#uploaderInput").click(function () {
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album'], // 可以指定来源是相册还是相机，默认二者都有
//            sourceType: ['album'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                wx.uploadImage({
                    localId: res.localIds.toString(), // 需要上传的图片的本地ID，由chooseImage接口获得
                    isShowProgressTips: 1, // 默认为1，显示进度提示
                    success: function (res) {
                        var serverId = res.serverId; // 返回图片的服务器端ID
                        $.ajax({
                            type: 'POST',
                            url: '/user/saveimg',
                            data: {
                                serverId: serverId
                            },
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                if (data.errno == 0) {
                                    photos += data.url+',';
                                    $('#card_url').val(photos);
                                    $('#uploaderFiles').append('<li class="weui-uploader__file" ><img src="'+data.url+'" style="width:77px;height:77px;"></li>');
                                }
                            }
                        });
                    }
                })
            }
        });
    });

    @if (session('success'))
    $.toptip("{{session('success')}}", 2000, 'success');  //设置显示时间
    @endif
    @if (session('error'))
    $.toptip("{{session('error')}}", 2000, 'error');  //设置显示时间
    @endif

</script>


</body>

</html>
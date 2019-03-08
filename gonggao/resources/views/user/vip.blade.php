<!DOCTYPE html>
<html>

<head>
    <title>小记者</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

<div class="weui-msg">
    <div class="weui-msg__text-area">
        <h2 class="weui-msg__title"> 注册会员成为小记者 </h2>
        <p class="weui-msg__desc">成为小记者可以。。。。。。</p>
    </div>
</div>

<div class="weui-msg__opr-area">
    <p class="weui-btn-area">
        <button class="weui-btn weui-btn_primary" onclick="btn()">支付</button>
    </p>
</div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>

<!-- 如果使用了某些拓展插件还需要额外的JS -->
<script src="/js/swiper.min.js"></script>
<script src="/js/city-picker.min.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config({!! $js->config(array('chooseImage','uploadImage','downloadImage'),false)  !!});
</script>

<script>

    function btn(){
        wx.chooseWXPay({
            timestamp: "{{$config['timestamp']}}", // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
            nonceStr: '{{$config['nonceStr']}}', // 支付签名随机串，不长于 32 位
            package: '{{$config['package']}}', // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
            signType: '{{$config['signType']}}', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
            paySign: '{{$config['paySign']}}', // 支付签名
            success: function (res) {
                window.location.href='/activity/result1?id={{$id}}';
            },
            fail: function (res) {
                alert("支付失败，请返回重试。");
            }
        });
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
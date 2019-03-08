
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>活动详情</title>
    <link rel="stylesheet" type="text/css" href="/css/aui.css" />
    <link rel="stylesheet" href="/css/weui.min.css">
    <link rel="stylesheet" href="/css/jquery-weui.min.css">
    <style type="text/css">
        .aui-list .aui-list-item-media {
            width: 6rem;
        }
    </style>
</head>
<body>
<div class="aui-content">
    <ul class="aui-list aui-media-list">
        <li class="aui-list-item">
            <div class="aui-list-item-inner">
                <p class="aui-ellipsis-2">{!! $activity->arrange !!}</p><br/>
            </div>
        </li>
    </ul>
    @if($activity->num==$activity->limit)
        <div class="aui-btn aui-btn-info aui-btn-block" style="margin-bottom: 20px;">人数已满</div>
    @else
        @if($jz->hasActivity($activity->id)>0)
            <div class="aui-btn aui-btn-info aui-btn-block" style="margin-bottom: 20px;">你已参加该活动</div>
        @else
            @if($activity->money>0)
                <div class="aui-btn aui-btn-info aui-btn-block" onclick="btn()" style="margin-bottom: 20px;">报名</div>
            @else
                <div class="aui-btn aui-btn-info aui-btn-block" onclick="vip_type()" style="margin-bottom: 20px;">报名</div>
            @endif
        @endif
    @endif
</div>
</body>
<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    wx.config({!! $js->config(array('chooseImage','uploadImage','downloadImage'),false)  !!});
</script>

<script type="text/javascript">
        function btn(){
            @if($jz->vip_type==1)
                @if($activity->money>0)
                wx.chooseWXPay({
                    timestamp: "{{$config['timestamp']}}", // 支付签名时间戳，注意微信jssdk中的所有使用timestamp字段均为小写。但最新版的支付后台生成签名使用的timeStamp字段名需大写其中的S字符
                    nonceStr: '{{$config['nonceStr']}}', // 支付签名随机串，不长于 32 位
                    package: '{{$config['package']}}', // 统一支付接口返回的prepay_id参数值，提交格式如：prepay_id=***）
                    signType: '{{$config['signType']}}', // 签名方式，默认为'SHA1'，使用新版支付需传入'MD5'
                    paySign: '{{$config['paySign']}}', // 支付签名
                    success: function (res) {
                        window.location.href='/activity/result?activity_id={{$activity->id}}&user_id={{$jz->id}}';
                    },
                    fail: function (res) {
                        alert("支付失败，请返回重试。");
                    }
                });
                @endif
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

        function vip_type(){
            @if($jz->vip_type==1)
                window.location.href='/activity/result?activity_id={{$activity->id}}&user_id={{$jz->id}}';
            @else
            $.confirm({
                title: '成为会员?',
                text: '成为会员才能参加活动/公开课。',
                onOK: function () {
                    location.href='/activity/vip?id={{$jz->id}}';
                },
                onCancel: function () {
                }
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
</html>
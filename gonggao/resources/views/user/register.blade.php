<!DOCTYPE html>
<html>

<head>
    <title>注册小记者账号</title>
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
</style>

<body ontouchstart>

<header class='demos-header' style="  display: flex;
        justify-content: center;
        align-items: center;  ">
    <img style="height: 150px; vertical-align:middle; margin: 30px 0 10px 0" src="/images/jz.jpg">
</header>

<div id="tab2" class="weui-tab__bd-item">
    <form method="post" action="/user/binding" enctype ="multipart/form-data">
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">姓名</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="请输入真实姓名" style="font-size: 13px;">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">身份证号</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="card" id="card" value="{{ old('card') }}" placeholder="请输入身份证号" style="font-size: 13px;">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">性别</label></div>
                <div class="weui-cell__bd">
                    <div class="page__bd page__bd_spacing">
                        <div class="weui-flex text-center">
                            <div class="weui-flex__item"><div class="placeholder" data-news="男">
                                    男<i class="weui-icon-success-no-circle" style="padding-bottom: 5px;"></i>
                                </div></div>
                            <div class="weui-flex__item"><div class="placeholder" data-news="女">女</div></div>
                        </div>
                        <input type="hidden" name="sex" value="男" id="yzcd">
                    </div>
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">年龄</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="age" id="age" value="{{ old('age') }}" placeholder="请选择年龄" style="font-size: 13px;">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">学校/班级</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="class" id="class" value="{{ old('class') }}" placeholder="请选择学校/班级" style="font-size: 13px;">
                </div>
            </div>
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">联系电话</label></div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="number" name="phone" id="phone" value="{{ old('photo') }}" placeholder="请输入手机号" style="font-size: 13px;">
                </div>
            </div>

            <div class="weui-cell">
                <div class="weui-cell__bd">
                    <div class="weui-uploader">
                        <div class="weui-uploader__hd">
                            <p class="weui-uploader__title">上传个人头像</p>
                            <div class="weui-uploader__info" style="font-size: 13px;">请上传清晰大头照</div>
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
                <button class="weui-btn weui-btn_primary" id="showTooltips">注册</button>
            </div>
        </div>
    </form>

    <div class="weui-footer" style="margin: 10px 0 20px 0">
        <p class="weui-footer__text">提示：注册缴费成为小记者才能参加活动和核心素养课</p>
    </div>
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

    $('.placeholder').click(function(){
        $('.placeholder').children('i').remove();
        $(this).append('<i class="weui-icon-success-no-circle" style="padding-bottom: 5px;"></i>')
        $('#yzcd').attr('value',$(this).attr('data-news'));

    });

    $("#showTooltips").click(function() {
        var tel = $('#phone').val();
        var age = $('#age').val();
        var class1= $('#class').val();
        var name = $('#name').val();
        var card = $('#card').val();
        var card_url = $('#card_url').val();
        if(!name){
            $.alert('请输入姓名');
            return false;
        }
        else if(!card || card.length!=18){
            $.alert('请正确输入身份证号');
            return false;
        }
        else if(!age){
            $.alert('请选择年龄');
            return false;
        }
        else if(!class1){
            $.alert('请选择学校/班级');
            return false;
        }
        else if(!tel || !/1[3|4|5|7|8]\d{9}/.test(tel)){
            $.alert('请输入正确手机号');
            return false;
        }
        else if(!card_url){
            $.alert('请上传头像');
            return false;
        }
        //else $.toptip('提交成功', 'success');
    });

    $("#login").click(function() {
        var name_login = $('#name_login').val();
        var num=$('#num').val();
        if(!name_login){
            $.alert('请输入姓名');
            return false;
        }
        else if(!num){
            $.alert('请输入小记者编号');
            return false;
        }

    });


    $("#uploaderInput").click(function(){
        wx.chooseImage({
            count: 1, // 默认9
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                $("#uploaderFiles").empty();
                $("#uploaderFiles").append("<img class='weui-uploader__file' src='"+localIds+"'>");
                $("#weui-uploader__input-box1").css('display','none');
                uploadimg(localIds[0].toString(),'card_url');
            }
        });
    });

    function uploadimg(lid,card_url) {
        wx.uploadImage({
            localId: lid, // 需要上传的图片的本地ID，由chooseImage接口获得
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
                    success: function(data){
                        //alert(data.url)
                        if(data.errno==0){
                            $('#'+card_url).val(data.url);
                        }
                    }
                });
            }
        })
    }

    $("#age").picker({
        title: "请选择年龄",
        cols: [
            {
                textAlign: 'center',
                values: ['6','7','8','9','10','11','12','13','14','15']
            }
        ]
    });

    var classs=[];
    @foreach($classs as $class)
    classs.push("{{$class->name}}")
    @endforeach
    $("#class").picker({
        title: "请选择学校/班级",
        cols: [
            {
                textAlign: 'center',
                values: classs
                //如果你希望显示文案和实际值不同，可以在这里加一个displayValues: [.....]
            },
            {
                textAlign: 'center',
                values: ['一年级', '二年级', '三年级', '四年级', '五年级', '六年级']
            },
            {
                textAlign: 'center',
                values: ['1班', '2班', '3班', '4班', '5班', '6班', '7班', '8班', '9班', '10班','11班','12班','13班','14班','15班']
            }
        ]
    });

    @if (session('success'))
    $.alert("{{session('success')}}");
    @endif
    @if (session('error'))
    $.alert("{{session('error')}}");
    @endif

</script>
</body>

</html>
<!--_meta 作为公共模版分离出去-->
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>

    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/lib/layer/2.4/skin/layer.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />

    <link href="/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
</head>
<script src="/laydate/laydate.js"></script>
<body>
<div class="page-container">
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>小记者姓名：</label>
        <div class="formControls col-xs-8 col-sm-9">
            {{$user->name}}
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>缴费金额：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="number" class="input-text" value="" placeholder="请输入缴费金额" id="num" name="num">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>缴费类型：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="select-box">
              <select class="select" size="1" name="type" id="type">
                  @if($user->vip_type==0)
                  <option value="会员" selected>会员</option>
                  @endif
                  @foreach($activitys as $activity)
                      @if($user->hasActivity($activity->id)==0)
                      <option value="{{$activity->id}}">{{$activity->name}}</option>
                      @endif
                  @endforeach
              </select>
            </span>
        </div>
    </div>

    <button onclick="Check();" class="btn btn-primary radius" style="margin: 0 0 10px 30px">缴费</button>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script>
<script language="javascript" type="text/javascript">
    function Check() {
        if ($("#num").val() == "") {
            alert('请输入金额！');
        }
        if ($("#type").val() == null) {
            alert('此小记者已报名所有活动！');
        }

        $.ajax({
            type: 'post',
            url: '/admin_user/pay',
            data: {
                num:$("#num").val(),
                type:$("#type").val(),
                user_id:'{{$user->id}}',
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.error ==0 ){
                    layer.msg(data.msg, {
                        icon: 1,
                        time: 2000, //2秒关闭（如果不配置，默认是3秒）
                        shade:0.5
                    });
                    parent.location.reload();
                    window.close();
                }else{
                    layer.msg(data.msg, {
                        icon: 2,
                        time: 2000, //2秒关闭（如果不配置，默认是3秒）
                        shade:0.5
                    });
                }
            }
        });

    }
</script>
</body>
</html>
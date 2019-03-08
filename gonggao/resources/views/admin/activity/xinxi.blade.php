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

    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/lib/layer/2.4/skin/layer.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
    <link href="/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/styles/simditor.css">
    <script type="text/javascript"  src="/scripts/module.js"></script>
    <script type="text/javascript"  src="/scripts/hotkeys.js"></script>
    <script type="text/javascript"  src="/scripts/uploader.js"></script>
    <script type="text/javascript"  src="/scripts/simditor.js"></script>


</head>
<script src="/laydate/laydate.js"></script>
<body>
<div class="page-container">
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动名称：</label>
        <div class="formControls col-xs-8 col-sm-9">
            {{$activity->name}}
        </div>
    </div>

    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2">学校：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="select-box">
                    <select class="select" size="1" name="school" id="school">
                        <option value="1" selected>所有</option>
                        @foreach($schools as $k=>$school)
                            <option value="{{$school->name}}">{{$school->name}}</option>
                        @endforeach
                    </select>
            </span>
        </div>
    </div>

    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2">年级：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="select-box">
                    <select class="select" size="1" name="grade" id="grade">
                        <option value="1" selected>所有</option>
                        @foreach($grades as $grade)
                            <option value="{{$grade}}">{{$grade}}</option>
                        @endforeach
                    </select>
            </span>
        </div>
    </div>

    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2">班级：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="select-box">
                    <select class="select" size="1" name="class" id="class">
                        <option value="1" selected>所有</option>
                        @foreach($classs as $class)
                            <option value="{{$class}}">{{$class}}</option>
                        @endforeach
                    </select>
            </span>
        </div>
    </div>

    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动开始时间：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" class="input-text" name="time" id="test5" placeholder="请选择日期和时间(选填)">
                </div>
            </div>
        </div>
    </div>

    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动开始地点：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" value="" placeholder="请输入活动开始地点(选填)" id="location" name="location">
        </div>
    </div>
    <input type="hidden" value="{{$activity->id}}" id="activity_id">
    <button onclick="Check();" class="btn btn-primary radius" style="margin: 0 0 10px 30px">发送</button>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script>
<script language="javascript" type="text/javascript">

    //日期时间选择器
    laydate.render({
        elem: '#test5'
        ,type: 'datetime'
    });

    function Check() {
        $.ajax({
            type: 'post',
            url: '/admin_activity/xinxi',
            data: {
                id:$("#activity_id").val(),
                school:$("#school").val(),
                grade:$("#grade").val(),
                class1:$("#class").val(),
                time:$("#test5").val(),
                location:$("#location").val(),
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data){
                if(data.error ==0){
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
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
            <input type="text" class="input-text" value="" placeholder="请输入活动名称" id="name" name="name">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动费用：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="number" class="input-text" value="" placeholder="请输入活动费用" id="money" name="money">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动限制人数：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="number" class="input-text" value="" placeholder="请输入活动限制人数" id="limit" name="limit">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动积分：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="number" class="input-text" value="" placeholder="请输入活动积分" id="point" name="point">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动开始时间：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" class="input-text" name="start_time" id="test5" placeholder="请选择日期和时间">
                </div>
            </div>
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动结束时间：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" class="input-text" name="end_time" id="end_time" placeholder="请选择日期和时间">
                </div>
            </div>
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动开始地点：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" value="" placeholder="请输入活动开始地点" id="start_location" name="start_location">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动结束地点：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" value="" placeholder="请输入活动结束地点" id="end_location" name="end_location">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>活动介绍：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <textarea name="arrange" id="editor" cols="100" rows="8" style="visibility:hidden;" placeholder="说点什么...最少输入10个字符">
            </textarea>
        </div>
    </div>



    <button onclick="Check();" class="btn btn-primary radius" style="margin: 0 0 10px 30px">添加</button>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script>
<script language="javascript" type="text/javascript">

    $(document).ready(function(){
        var editor = new Simditor({
            textarea: $('#editor'),
            upload: {
                url: '{{ route('activity.upload_image') }}',
                params: { _token: '{{ csrf_token() }}' },
                fileKey: 'upload_file',
                connectionCount: 3,
                leaveConfirm: '文件上传中，关闭此页面将取消上传。'
            },
            pasteImage: true,
        });
    });

    //日期时间选择器
    laydate.render({
        elem: '#test5'
        ,type: 'datetime'
    });
    laydate.render({
        elem: '#end_time'
        ,type: 'datetime'
    });

    function Check() {
        if ($("#name").val() == "") {
            alert('请输入姓名！');
            return false;
        }
        if ($("#money").val() == "") {
            alert('请输入活动费用！');
            return false;
        }
        if ($("#point").val() == "") {
            alert('请输入活动积分！');
            return false;
        }
        if ($("#limit").val() == "") {
            alert('请输入活动限制人数！');
            return false;
        }
        if ($("#test5").val() == "") {
            alert('请输入活动开始时间！');
            return false;
        }
        if ($("#end_time").val() == "") {
            alert('请输入活动开始时间！');
            return false;
        }
        if ($("#start_localtion").val() == "") {
            alert('请输入开始地点！');
            return false;
        }
        if ($("#end_localtion").val() == "") {
            alert('请输入结束地点！');
            return false;
        }
        if ($("#editor").val() == "") {
            alert('请输入活动详情！');
            return false;
        }

        $.ajax({
            type: 'post',
            url: '/admin_activity/add',
            data: {
                name:$("#name").val(),
                money:$("#money").val(),
                point:$("#point").val(),
                limit:$("#limit").val(),
                start_time:$("#test5").val(),
                end_time:$("#end_time").val(),
                start_location:$("#start_location").val(),
                end_location:$("#end_location").val(),
                arrange:$("#editor").val(),
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
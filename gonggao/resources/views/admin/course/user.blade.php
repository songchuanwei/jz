
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />

    <title>活动现场</title>
</head>
<style>
    .dataTables_paginate{
        display: none;
    }
    #pull_right{
        text-align:center;
    }
    .pull-right {
        float: right;
    }
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
    }
    .pagination > li {
        display: inline;
    }
    .pagination > li > a,
    .pagination > li > span {
        position: relative;
        float: left;
        padding: 6px 12px;
        margin-left: -1px;
        line-height: 1.42857143;
        color: #428bca;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #ddd;
    }
    .pagination > li:first-child > a,
    .pagination > li:first-child > span {
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .pagination > li:last-child > a,
    .pagination > li:last-child > span {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .pagination > li > a:hover,
    .pagination > li > span:hover,
    .pagination > li > a:focus,
    .pagination > li > span:focus {
        color: #2a6496;
        background-color: #eee;
        border-color: #ddd;
    }
    .pagination > .active > a,
    .pagination > .active > span,
    .pagination > .active > a:hover,
    .pagination > .active > span:hover,
    .pagination > .active > a:focus,
    .pagination > .active > span:focus {
        z-index: 2;
        color: #fff;
        cursor: default;
        background-color: #428bca;
        border-color: #428bca;
    }
    .pagination > .disabled > span,
    .pagination > .disabled > span:hover,
    .pagination > .disabled > span:focus,
    .pagination > .disabled > a,
    .pagination > .disabled > a:hover,
    .pagination > .disabled > a:focus {
        color: #777;
        cursor: not-allowed;
        background-color: #fff;
        border-color: #ddd;
    }
    .clear{
        clear: both;
    }
</style>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 活动报名小记者 <span class="c-gray en">&gt;</span> 活动报名小记者管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">


        <label class="form-label col-xs-4 col-lg-4" style="width: 140px; margin: 0 0 0 80px;">请先选择活动：</label>
        <div class="formControls col-xs-1 col-sm-3"  style="margin: 0 0 0 10px;">
            <span class="select-box">
                    <select class="select" size="1" name="course" id="course">
                        @foreach($courses as $course1)
                            @if($course1->id==$course->id)
                                <option value="{{$course1->id}}" selected="selected">{{$course1->name}}</option>
                            @else
                                <option value="{{$course1->id}}">{{$course1->name}}</option>
                            @endif
                        @endforeach
                    </select>
            </span>
        </div>

        <span class="r">共有数据：<strong>{{$course->users()->count()}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th>ID</th>
                <th>活动报名小记者姓名</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($course->users()->paginate(10) as $user)
                <tr class="text-c">
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td class="td-manage">
                        <button class="btn btn-success radius" onClick="modaldemo({{$user->id}})">加减分</button>
                    </td>
                </tr>

                <div id="modal-demo{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content radius">
                            <div class="modal-header">
                                <h3 class="modal-title">给{{$user->name}}小记者打分</h3>
                                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                            </div>
                            <div class="modal-body">
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">活动名称：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$course->name}}</div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">小记者名称：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$user->name}}</div>
                                </div>
                                @if(empty($user->coursePoint($course->id)))
                                <div class="row cl">
                                    <div class="row cl" style="margin: 0 0 10px 0">
                                        <label class="form-label col-xs-4 col-sm-4 text-r"><span class="c-red">*</span>加减分数：</label>
                                        <div class="formControls col-xs-8 col-sm-6">
                                            <input type="number" id="point{{$user->id}}" name="point{{$user->id}}" class="input-text" value="" placeholder="正数加 负数减">
                                        </div>
                                    </div>
                                </div>
                                <div class="row cl" style="margin: 0 0 10px 0">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">加减分备注：</label>
                                    <div class="formControls col-xs-8 col-sm-6">
                                        <textarea cols="" rows="" class="textarea" name="content{{$user->id}}" id="content{{$user->id}}" placeholder="说点什么... (选填)"></textarea>
                                    </div>
                                </div>
                                @else
                                    <div class="row cl">
                                        <div class="row cl" style="margin: 0 0 10px 0">
                                            <label class="form-label col-xs-4 col-sm-4 text-r"><span class="c-red">*</span>加减分数：</label>
                                            <div class="formControls col-xs-8 col-sm-6">
                                                <input type="number" id="point{{$user->id}}" name="point{{$user->id}}" class="input-text" value="{{$user->coursePoint($course->id)->point}}" placeholder="正数加 负数减">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row cl" style="margin: 0 0 10px 0">
                                        <label class="form-label col-xs-4 col-sm-4 text-r">加减分备注：</label>
                                        <div class="formControls col-xs-8 col-sm-6">
                                            <textarea cols="" rows="" class="textarea" name="content{{$user->id}}" id="content{{$user->id}}" placeholder="说点什么... (选填)">{{$user->coursePoint($course->id)->content}}</textarea>
                                        </div>
                                    </div>
                                @endif
                                <button onclick="Check('{{$course->id}}','{{$user->id}}');" class="btn btn-primary radius" style="margin: 0 0 10px 30px">添加</button>
                            </div>
                            <div class="modal-footer">
                                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
            </tbody>
        </table>

        <div id="pull_right">
            <div class="pull-right">
                {!! $course->users()->paginate(10)->render() !!}
            </div>
        </div>
    </div>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    $(function(){
        $('.table-sort').dataTable({
            "aaSorting": [[ 1, "desc" ]],//默认第几个排序
            "bStateSave": true,//状态保存
            "aoColumnDefs": [
                //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
                //{"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
            ]
        });

    });

    function modaldemo(aa){
        $("#modal-demo"+aa).modal("show")}

    $('#course').bind('input propertychange', function() {
        $(location).attr('href', '/admin_course/user?course='+$("#course").val());
    });

    function Check(course_id,user_id) {
        if ($("#point"+user_id).val() == "") {
            alert('请输入加减分数！');
            return false;
        }

        $.ajax({
            type: 'post',
            url: '/admin_course/userpoint',
            data: {
                point:$("#point"+user_id).val(),
                content:$("#content"+user_id).val(),
                user_id:user_id,
                point_id:course_id,
                type:2
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
                    location.replace(location.href);
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
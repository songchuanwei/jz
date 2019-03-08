
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>活动管理</title>
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
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 活动中心 <span class="c-gray en">&gt;</span> 活动管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <form method="get" action="/admin_activity/index">
            <input type="text" class="input-text" style="width:250px" id="title" name="title" placeholder="输入活动名称、开始地点、结束地点"><button type="submit" class="btn btn-success"><i class="icon-search"></i> 搜索</button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
        <a href="javascript:;" onclick="Add()" class="btn btn-primary radius"><i class="icon-plus"></i> 添加活动</a></span>
        <span class="r">共有数据：<strong>{{$activitys->count()}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th>ID</th>
                <th>活动名称</th>
                <th>活动费用</th>
                <th>活动积分</th>
                <th>活动实际人数/限制人数</th>
                <th>活动开始时间</th>
                <th>活动结束时间</th>
                <th>活动开始地点</th>
                <th>活动结束地点</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activitys as $activity)
            <tr class="text-c">
                <td onClick="modaldemo({{$activity->id}})">{{$activity->id}}</td>
                <td onClick="modaldemo({{$activity->id}})">{{mb_substr($activity->name,0,10)}}...</td>
                <td onClick="modaldemo({{$activity->id}})">{{$activity->money}}</td>
                <td onClick="modaldemo({{$activity->id}})">{{$activity->point}}</td>
                <td onClick="modaldemo({{$activity->id}})">{{$activity->num}}/{{$activity->limit}}</td>
                <td onClick="modaldemo({{$activity->id}})">{{date("Y-m-d H:i",strtotime($activity->start_time))}}</td>
                <td onClick="modaldemo({{$activity->id}})">{{date("Y-m-d H:i",strtotime($activity->end_time))}}</td>
                <td onClick="modaldemo({{$activity->id}})">{{$activity->start_location}}</td>
                <td onClick="modaldemo({{$activity->id}})">{{$activity->end_location}}</td>
                @if($activity->status==1)
                <td class="td-status"><span class="label label-success radius">已启用</span></td>
                @else
                <td class="td-status"><span class="label label-danger radius">已禁用</span></td>
                @endif
                <td class="td-manage">
                    @if(strtotime($activity->start_time) > time())
                        <button class="btn btn-warning radius" onClick="xinxi('{{$activity->id}}')">发送通知消息</button>
                    @endif
                    <button class="btn btn-success radius" onClick="modaldemo({{$activity->id}})">查看</button>
                    <button type="submit" class="btn btn-secondary radius" onclick="Edit('{{$activity->id}}')">编辑</button>
                </td>
            </tr>

            <div id="modal-demo{{$activity->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content radius">
                        <div class="modal-header">
                            <h3 class="modal-title">{{$activity->name}}</h3>
                            <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                        </div>
                        <div class="modal-body">
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-4 text-r">活动名称：</label>
                                <div class="formControls col-xs-8 col-sm-6">{{$activity->name}}</div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-4 text-r">活动费用：</label>
                                <div class="formControls col-xs-8 col-sm-6">{{$activity->money}}</div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-4 text-r">活动积分：</label>
                                <div class="formControls col-xs-8 col-sm-6">{{$activity->point}}</div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-4 text-r">活动实际人数/限制人数：</label>
                                <div class="formControls col-xs-8 col-sm-6">{{$activity->num}}/{{$activity->limit}}</div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-4 text-r">活动开始时间：</label>
                                <div class="formControls col-xs-8 col-sm-6">{{date("Y-m-d H:i",strtotime($activity->start_time))}}</div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-4 text-r">活动结束时间：</label>
                                <div class="formControls col-xs-8 col-sm-6">{{date("Y-m-d H:i",strtotime($activity->end_time))}}</div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-4 text-r">活动开始地点：</label>
                                <div class="formControls col-xs-8 col-sm-6">{{$activity->start_location}}</div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-4 text-r">活动结束地点：</label>
                                <div class="formControls col-xs-8 col-sm-6">{{$activity->end_location}}</div>
                            </div>
                            <div class="row cl">
                                <label class="form-label col-xs-4 col-sm-4 text-r">活动内容：</label>
                                <div class="formControls col-xs-8 col-sm-6">{!! $activity->arrange !!}</div>
                            </div>
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
                {!! $activitys->render() !!}
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
                {"orderable":false,"aTargets":[0,8,9]}// 制定列不参与排序
            ]
        });

    });
    function modaldemo(aa){
        $("#modal-demo"+aa).modal("show")}

    function activity_new(id) {
        layer.open({
            type: 2,
            title: '编辑活动',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['800px', '600px'],
            content: '/admin_activity/edit?id='+id
        });
    }

    function Edit(id) {
        layer.open({
            type: 2,
            title: '编辑活动',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['1000px', '600px'],
            content: '/admin_activity/edit?id='+id
        });
    }
    function Add() {
        layer.open({
            type: 2,
            title: '添加活动',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['1000px', '600px'],
            content: '/admin_activity/add'
        });
    }
    function del(id) {
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/admin_activity/del?id='+id,
                success: function(data){
                    if(data.ennor==0){
                        layer.msg(data.msg,{icon:1,time:1000});
                    }else{
                        layer.msg(data.msg,{icon:2,time:1000});
                    }
                    location.reload();
                },
            });
        });
    }

    function xinxi(id) {
        layer.open({
            type: 2,
            title: '发送活动信息',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['800px', '600px'],
            content: '/admin_activity/xinxi?id='+id
        });
    }


</script>
</body>
</html>

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
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>学校管理</title>
</head>
<style>
    .dataTables_paginate{
        display: none;
    }
</style>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 学校中心 <span class="c-gray en">&gt;</span> 学校管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <form method="get" action="/admin_class/index">
            <input type="text" class="input-text" style="width:250px" id="title" name="title" placeholder="输入学校名称、学校编号"><button type="submit" class="btn btn-success"><i class="icon-search"></i> 搜索</button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
        <a href="javascript:;" onclick="Add()" class="btn btn-primary radius"><i class="icon-plus"></i> 添加学校</a></span>
        <span class="r">共有数据：<strong>{{$classs->count()}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th>ID</th>
                <th>学校名称</th>
                <th>学校编号</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($classs as $class)
                <tr class="text-c">
                    <td>{{$class->id}}</td>
                    <td>{{$class->name}}</td>
                    <td>{{$class->num}}</td>
                    <td>{{$class->created_at}}</td>
                    <td class="td-manage">
                        <button type="submit" class="btn btn-secondary radius" onclick="Edit('{{$class->id}}')">编辑</button>
                        <button type="submit" class="btn btn-danger radius" onclick="del('{{$class->id}}')">删除</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float: right; margin: -10px 30px 0 0">
            {!! $classs->render() !!}
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

    function Edit(id) {
        layer.open({
            type: 2,
            title: '编辑学校',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['800px', '600px'],
            content: '/admin_class/edit?id='+id
        });
    }
    function Add() {
        layer.open({
            type: 2,
            title: '添加学校',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['800px', '600px'],
            content: '/admin_class/add'
        });
    }
    function del(id) {
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/admin_class/del?id='+id,
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

</script>
</body>
</html>
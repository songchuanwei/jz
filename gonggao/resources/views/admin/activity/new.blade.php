
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
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 活动现场 <span class="c-gray en">&gt;</span> 活动现场管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
        <a href="javascript:;" onclick="Add()" class="btn btn-primary radius"><i class="icon-plus"></i> 添加活动现场</a></span>

        <label class="form-label col-xs-4 col-lg-4" style="width: 120px; margin: 0 0 0 80px;">请选择活动：</label>
        <div class="formControls col-xs-1 col-sm-3"  style="margin: 0 0 0 10px;">
            <span class="select-box">
                    <select class="select" size="1" name="segment" id="segment">
                        @foreach($activitys as $activity)
                            @if($activity->id==$segment)
                                <option value="{{$activity->id}}" selected="selected">{{$activity->name}}</option>
                            @else
                                    <option value="{{$activity->id}}">{{$activity->name}}</option>
                            @endif
                        @endforeach
                    </select>
            </span>
        </div>

        <span class="r">共有数据：<strong>{{$news->count()}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th>ID</th>
                <th>活动名称</th>
                <th>现场标题</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($news as $new)
                <tr class="text-c">
                    <td onClick="modaldemo({{$new->id}})">{{$new->id}}</td>
                    <td onClick="modaldemo({{$new->id}})">{{mb_substr($new->activity_name,0,10)}}...</td>
                    <td onClick="modaldemo({{$new->id}})">{{mb_substr($new->content,0,20)}}...</td>
                    <td class="td-manage">
                        <button class="btn btn-success radius" onClick="modaldemo({{$new->id}})">查看</button>
                        <button type="submit" class="btn btn-danger radius" onclick="del('{{$new->id}}')">删除</button>
                    </td>
                </tr>

                <div id="modal-demo{{$new->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content radius">
                            <div class="modal-header">
                                <h3 class="modal-title">{{$new->activity_name}}</h3>
                                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                            </div>
                            <div class="modal-body">
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">活动名称：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$new->activity_name}}</div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">现场标题：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$new->content}}</div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">图片：</label>
                                    @foreach(explode(",", $new->photo) as $k=>$v)
                                        @if($k<count(explode(",", $new->photo))-1)
                                            <div class="aui-col-xs-4">
                                                <img width="100" class="picture-thumb" src="{{$v}}" style="float: left; margin: 10px 5px 10px 0">
                                            </div>
                                        @endif
                                    @endforeach
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
                {!! $news->render() !!}
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

    $('#segment').bind('input propertychange', function() {
        $(location).attr('href', '/admin_activity/new?segment='+$("#segment").val());
    });
    function Add() {
        layer.open({
            type: 2,
            title: '添加活动现场',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['800px', '600px'],
            content: '/admin_activity/newadd'
        });
    }
    function del(id) {
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/admin_activity/newdel?id='+id,
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
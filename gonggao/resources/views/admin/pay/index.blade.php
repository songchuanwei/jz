
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,pay-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <title>支付管理</title>
</head>
<style>
    .dataTables_paginate{
        display: none;
    }
</style>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 支付中心 <span class="c-gray en">&gt;</span> 支付管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">

        <label class="form-label col-xs-1 col-lg-1" style="width: 120px;">活动：</label>
        <div class="formControls col-xs-1 col-sm-2"  style="margin: 0 0 0 10px;">
            <span class="select-box">
                    <select class="select" size="1" name="activity" id="activity">
                        @foreach($activitys as $activity)
                            @if($activity->name == $request->activity)
                                <option value="{{$activity->name}}" selected="selected">{{$activity->name}}</option>
                            @else
                                <option value="{{$activity->name}}">{{$activity->name}}</option>
                            @endif
                        @endforeach
                    </select>
            </span>
        </div>

        <span style="margin-left: 200px;">此活动总金额：<strong style="color: red;">{{$sum}}</strong></span>

        <span class="r">共有数据：<strong>{{$pays->count()}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th>小记者姓名</th>
                <th>支付类别</th>
                <th>支付金额</th>
                <th>支付方式</th>
                <th>支付时间</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pays as $pay)
                <tr class="text-c">
                    <td>{{$pay->user->name}}</td>
                    <td>{{$pay->type}}</td>
                    <td>{{$pay->num}}</td>
                    @if($pay->pay_type==1)
                        <td>线上</td>
                    @else
                        <td>线下</td>
                    @endif
                    <td>{{$pay->created_at}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="float: right; margin: -10px 30px 0 0">
            {!! $pays->render() !!}
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

        $('#activity').bind('input propertychange', function() {
            $(location).attr('href', '/admin_pay/index?activity='+$("#activity").val());
        });
    });
</script>
</body>
</html>
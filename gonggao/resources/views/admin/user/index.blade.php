
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <title>小记者管理</title>
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
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 小记者中心 <span class="c-gray en">&gt;</span> 小记者管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">

    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
        <a href="javascript:;" onclick="Add()" class="btn btn-primary radius"><i class="icon-plus"></i> 添加小记者</a></span>
        {{--<span class="l"><a href="javascript:;" style="margin-left: 10px;" onclick="excelput()" class="btn btn-primary radius"><i class="icon-plus"></i> 导出小记者信息</a></span>--}}
        {{--<span class="btn-upload form-group" style="margin-left: 40%">--}}
        {{--<input class="input-text upload-url radius" type="text" name="excel1" id="excel1" readonly><a href="javascript:void();" class="btn btn-primary radius"> 导入小记者Excel文件</a>--}}
        {{--<input type="file" multiple name="excel" id="excel" class="input-file">--}}
        {{--</span>--}}
            {{--<span class="btn-upload form-group">--}}
        {{--<a href="javascript:;" onclick="excel()" class="btn btn-primary radius"><i class="icon-plus"></i> 提交</a></span>--}}
        <span class="r">共有数据：<strong>{{$users->count()}}</strong> 条</span>
    </div>

    <div class="cl pd-5 bg-1 bk-gray mt-20">

        <label class="form-label col-xs-1 col-lg-1" style="width: 120px;">学校：</label>
        <div class="formControls col-xs-1 col-sm-2"  style="margin: 0 0 0 10px;">
            <span class="select-box">
                    <select class="select" size="1" name="school" id="school">
                        <option value="所有">所有</option>
                        @foreach($schools as $k=>$school)
                            @if($school->name==$request->school)
                                <option value="{{$school->name}}" selected>{{$school->name}}</option>
                            @else
                                <option value="{{$school->name}}">{{$school->name}}</option>
                            @endif
                        @endforeach
                    </select>
            </span>
        </div>

        <label class="form-label col-xs-1 col-lg-1" style="width: 120px;">年级：</label>
        <div class="formControls col-xs-1 col-sm-2"  style="margin: 0 0 0 10px;">
            <span class="select-box">
                    <select class="select" size="1" name="grade" id="grade">
                        <option value="所有">所有</option>
                        @foreach($grades as $grade)
                            @if($grade==$request->grade)
                                <option value="{{$grade}}" selected>{{$grade}}</option>
                            @else
                                <option value="{{$grade}}">{{$grade}}</option>
                            @endif
                        @endforeach
                    </select>
            </span>
        </div>

        <label class="form-label col-xs-1 col-lg-1" style="width: 120px;">班级：</label>
        <div class="formControls col-xs-1 col-sm-2"  style="margin: 0 0 0 10px;">
            <span class="select-box">
                    <select class="select" size="1" name="class" id="class">
                        <option value="所有">所有</option>
                        @foreach($classs as $class)
                            @if($class==$request->class)
                                <option value="{{$class}}" selected>{{$class}}</option>
                            @else
                                <option value="{{$class}}">{{$class}}</option>
                            @endif
                        @endforeach
                    </select>
            </span>
        </div>

        <span class="l"><a href="javascript:;" style="margin-left: 10px;" onclick="excelput()" class="btn btn-primary radius"><i class="icon-plus"></i> 导出小记者信息</a></span>

    </div>

    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th>小记者编号</th>
                <th>姓名</th>
                <th>身份证号</th>
                <th>性别</th>
                <th>头像</th>
                <th>学校/年级/班级</th>
                <th>家长手机号</th>
                <th>积分</th>
                <th>是否为会员</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="text-c">
                    @if($user->vip_type==1)
                        <td class="td-status">{{$user->num}}</td>
                    @else
                        <td class="td-status">不是会员</td>
                    @endif
                    <td>{{$user->name}}</td>
                    <td>{{$user->card?$user->card:'未填写'}}</td>
                    <td>{{$user->sex}}</td>
                    @if($user->photo==NULL)
                        <td>没有上传头像</td>
                    @else
                        <td><img src="{{$user->photo}}" class="radius" width="50px" height="50px"> </td>
                    @endif
                    <td>{{$user->school}}-{{$user->grade}}-{{$user->class}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->Courses()->sum('point')+$user->Activitys()->sum('point')+$user->Acticles()->sum('point')+$user->Points()->sum('point')}}</td>
                    @if($user->vip_type==1)
                        <td class="td-status"><span class="label label-success radius">是</span></td>
                    @else
                        <td class="td-status"><span class="label label-danger radius">否</span></td>
                    @endif
                    <td class="td-manage">
                        <button type="submit" class="btn btn-success radius" onclick="pay('{{$user->id}}')">缴费</button>
                        <button type="submit" class="btn btn-secondary radius" onclick="Edit('{{$user->id}}')">编辑</button>
                        <button type="submit" class="btn btn-primary radius" onClick="modaldemo({{$user->id}})">查看积分详情</button>
                    </td>
                </tr>

                <div id="modal-demo{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content radius">
                            <div class="modal-header">
                                <h3 class="modal-title">{{$user->name}}的积分详情   <span style="color: red; margin-left: 100px;">{{$user->Courses()->sum('point')+$user->Activitys()->sum('point')+$user->Acticles()->sum('point')+$user->Points()->sum('point')}}</span></h3>
                                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                            </div>
                            <div class="modal-body">
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">我参加的活动：</label><br>
                                    @foreach($user->Activitys()->get() as $activity)
                                        <label class="form-label col-xs-4 col-sm-4 text-r"></label>
                                        <div class="formControls col-xs-8 col-sm-6">
                                            <div>{{$activity->name}}</div>
                                            <div class="f-12 c-999">积分：{{$activity->point}}</div>
                                        </div><br>
                                    @endforeach
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">我参加的核心素养课：</label><br>
                                    @foreach($user->Courses()->get() as $course)
                                        <label class="form-label col-xs-4 col-sm-4 text-r"></label>
                                        <div class="formControls col-xs-8 col-sm-6">
                                            <div>{{$course->name}}</div>
                                            <div class="f-12 c-999">积分：{{$course->point}}</div>
                                        </div><br>
                                    @endforeach
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">我的投稿：</label><br>
                                    @foreach($user->Acticles()->get() as $acticle)
                                        <label class="form-label col-xs-4 col-sm-4 text-r"></label>
                                        <div class="formControls col-xs-8 col-sm-6">
                                                <div>{{$acticle->title}}</div>
                                            <div class="f-12 c-999">积分：{{$acticle->point}}</div>
                                        </div><br>
                                    @endforeach
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">我的加分扣分：</label><br>
                                    @foreach($user->Points()->get() as $point)
                                        @if($point->type==1)
                                            <label class="form-label col-xs-4 col-sm-4 text-r">我的活动加分扣分</label>
                                            <div class="formControls col-xs-8 col-sm-6">
                                                <div>{{$point->activity()->first()->name}}</div>
                                                <div class="f-12 c-999">积分：{{$point->point}}</div>
                                                <div class="f-12 c-999">备注：{{$point->content}}</div>
                                            </div><br>
                                        @else
                                            <label class="form-label col-xs-4 col-sm-4 text-r">我的核心素养课加分扣分</label>
                                            <div class="formControls col-xs-8 col-sm-6">
                                                <div>{{$point->course()->first()->name}}</div>
                                                <div class="f-12 c-999">积分：{{$point->point}}</div>
                                                <div class="f-12 c-999">备注：{{$point->content}}</div>
                                            </div><br>
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
                {!! $users->render() !!}
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

    $('#school').bind('input propertychange', function() {
        $(location).attr('href', '/admin_user/index?school='+$("#school").val()+'&grade='+$("#grade").val()+'&class='+$("#class").val());
    });

    $('#grade').bind('input propertychange', function() {
        $(location).attr('href', '/admin_user/index?school='+$("#school").val()+'&grade='+$("#grade").val()+'&class='+$("#class").val());
    });
    $('#class').bind('input propertychange', function() {
        $(location).attr('href', '/admin_user/index?school='+$("#school").val()+'&grade='+$("#grade").val()+'&class='+$("#class").val());
    });

    function modaldemo(aa){
        $("#modal-demo"+aa).modal("show")}

    function excel(){
        if ($("#excel").val() == "") {
            alert('请上传文件！');
            $("#excel").focus();
            var ev = window.event || ev;
            ev.returnValue = false;
            return false;
        }

        var file_obj = document.getElementById('excel').files[0];
        var formData = new FormData();
        formData.append("excel",file_obj);
        layer.msg('正在上传，请稍后！', {
            icon: 1,
            time: 5000, //2秒关闭（如果不配置，默认是3秒）
            shade:0.5
        });
        $.ajax({
            type: 'POST',
            url: '/admin_user/excel',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
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
                    window.close();
                }else{
                    layer.msg(data.msg, {
                        icon: 2,
                        time: 2000, //2秒关闭（如果不配置，默认是3秒）
                        shade:0.5
                    });
                }
            },
            error:function(data){
                layer.msg('异常', {
                    icon: 2,
                    time: 2000, //2秒关闭（如果不配置，默认是3秒）
                    shade:0.5
                });
            }
        });
    }

    function excelput() {
        layer.open({
            content: '学生信息生成中'
            ,skin: 'msg'
            ,time: 5000
            ,end: function () {
                location.href='/admin_user/excelput?school='+$("#school").val()+'&grade='+$("#grade").val()+'&class='+$("#class").val();
            }
        });
    }

    function Edit(id) {
        layer.open({
            type: 2,
            title: '编辑小记者',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['800px', '600px'],
            content: '/admin_user/edit?id='+id
        });
    }
    function Add() {
        layer.open({
            type: 2,
            title: '添加小记者',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['800px', '600px'],
            content: '/admin_user/add'
        });
    }

    function pay(id) {
        layer.open({
            type: 2,
            title: '小记者缴费',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['800px', '600px'],
            content: '/admin_user/pay?id='+id
        });
    }
</script>
</body>
</html>
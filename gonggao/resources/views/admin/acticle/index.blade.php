
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
    <title>稿件管理</title>
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
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 投稿中心 <span class="c-gray en">&gt;</span> 投稿管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <form method="get" action="/admin_acticle/index">
            <input type="text" class="input-text" style="width:250px" id="title" name="title" placeholder="输入稿件标题、内容"><button type="submit" class="btn btn-success"><i class="icon-search"></i> 搜索</button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
        <span class="r">共有数据：<strong>{{$acticles->count()}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-hover table-bg table-sort">
            <thead>
            <tr class="text-c">
                <th>ID</th>
                <th>投稿标题</th>
                <th>投稿人</th>
                <th>投稿时间</th>
                <th>积分</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($acticles as $acticle)
                <tr class="text-c">
                    <td onClick="modaldemo({{$acticle->id}})">{{$acticle->id}}</td>
                    <td onClick="modaldemo({{$acticle->id}})">{{mb_substr($acticle->title,0,10)}}...</td>
                    <td onClick="modaldemo({{$acticle->id}})">{{$acticle->user->name}}</td>
                    <td onClick="modaldemo({{$acticle->id}})">{{$acticle->created_at}}</td>
                    <td onClick="modaldemo({{$acticle->id}})">{{$acticle->point}}</td>
                    <td class="td-manage">
                        <button class="btn btn-success radius" onClick="modaldemo({{$acticle->id}})">查看</button>
                        <button type="submit" class="btn btn-danger radius" onclick="del('{{$acticle->id}}')">删除</button>
                    </td>
                </tr>

                <div id="modal-demo{{$acticle->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content radius">
                            <div class="modal-header">
                                <h3 class="modal-title">{{$acticle->title}}</h3>
                                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
                            </div>
                            <div class="modal-body">
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">投稿标题：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$acticle->title}}</div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">投稿人：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$acticle->user->name}}</div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">积分：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$acticle->point}}</div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">投稿时间：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$acticle->created_at}}</div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">图片：</label>
                                    @foreach(explode(",", $acticle->photo) as $k=>$v)
                                        @if($k<count(explode(",", $acticle->photo))-1)
                                            <div class="aui-col-xs-4">
                                                <img width="100" class="picture-thumb" src="{{$v}}" style="float: left; margin: 10px 5px 10px 0">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">投稿内容：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$acticle->content}}</div>
                                </div>
                                <div class="row cl">
                                    <label class="form-label col-xs-4 col-sm-4 text-r">审阅内容：</label>
                                    <div class="formControls col-xs-8 col-sm-6">{{$acticle->review?$acticle->review:'未审阅'}}</div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-primary radius" onclick="Edit('{{$acticle->id}}')">审阅</button>
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
                {!! $acticles->render() !!}
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

    function Edit(id) {
        layer.open({
            type: 2,
            title: '编辑投稿',
            maxmin: true,
            shadeClose: true, //点击遮罩关闭层
            area: ['800px', '600px'],
            content: '/admin_acticle/edit?id='+id
        });
    }
    function del(id) {
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'get',
                url: '/admin_acticle/del?id='+id,
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
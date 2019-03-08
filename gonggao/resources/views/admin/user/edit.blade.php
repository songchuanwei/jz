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
            <input type="text" class="input-text" value="{{$user->name}}" placeholder="请输入小记者姓名" id="name" name="name">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>小记者身份证号：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="text" class="input-text" value="{{$user->card}}" placeholder="请输入小记者身份证号" id="card" name="card">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>小记者年龄：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="number" class="input-text" value="{{$user->age}}" placeholder="请输入小记者年龄" id="age" name="age">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>小记者性别：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="select-box">
              <select class="select" size="1" name="sex" id="sex">
                  @if($user->sex=='男')
                  <option value="男" selected>男</option>
                  <option value="女">女</option>
                  @else
                  <option value="男">男</option>
                  <option value="女" selected>女</option>
                  @endif
              </select>
            </span>
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>小记者学校：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="select-box">
              <select class="select" size="1" name="school" id="school">
                  @foreach($schools as $k=>$school)
                      @if($school==$user->school)
                          <option value="{{$school->name}}" selected>{{$school->name}}</option>
                      @else
                          <option value="{{$school->name}}">{{$school->name}}</option>
                      @endif
                  @endforeach
              </select>
            </span>
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>小记者年级：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <span class="select-box">
              <select class="select" size="1" name="grade" id="grade">
                   @foreach($grades as $grade)
                      @if($grade==$user->grade)
                          <option value="{{$grade}}" selected>{{$grade}}</option>
                      @else
                          <option value="{{$grade}}">{{$grade}}</option>
                      @endif
                  @endforeach
              </select>
            </span>
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>小记者班级：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <select class="select" size="1" name="class" id="class">
                @foreach($classs as $class)
                    @if($class==$user->class)
                        <option value="{{$class}}" selected>{{$class}}</option>
                    @else
                        <option value="{{$class}}">{{$class}}</option>
                    @endif
                @endforeach
            </select>
            </span>
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>家长手机号：</label>
        <div class="formControls col-xs-8 col-sm-9">
            <input type="number" class="input-text" value="{{$user->phone}}" placeholder="请输入家长手机号" id="phone" name="phone">
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>上传头像：</label>
        <div class="formControls col-xs-8 col-sm-9">
           <span class="btn-upload form-group">
              <input class="input-text upload-url radius" type="text" name="uploadfile-1" id="uploadfile-1" readonly><a href="javascript:void();" class="btn btn-primary radius"><i class="iconfont">&#xf0020;</i> 浏览文件</a>
              <input type="file" multiple name="file-1" id="photo" class="input-file"><br>
            </span>
        </div>
    </div>
    <div class="row cl" style="margin: 0 0 10px 0">
        <label class="form-label col-xs-4 col-sm-2"></label>
        <div class="formControls col-xs-8 col-sm-9">
            @if($user->photo==NULL)
                没有上传头像
            @else
                <img src="{{$user->photo}}" class="radius" width="50px" height="50px">&nbsp;&nbsp;&nbsp;&nbsp;不选为不修改
            @endif
        </div>
    </div>

    <input type="hidden" value="{{$user->id}}" id="user_id">
    <button onclick="Check();" class="btn btn-primary radius" style="margin: 0 0 10px 30px">修改</button>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui.admin/js/H-ui.admin.js"></script>
<script language="javascript" type="text/javascript">
    function Check() {
        if ($("#name").val() == "") {
            alert('请输入姓名！');
            return false;
        }
        if ($("#card").val() == "" || $("#card").val().length!=18) {
            alert('请正确输入身份证号！');
            return false;
        }
        if ($("#age").val() == "") {
            alert('请输入年龄！');
            return false;
        }
        var phone=$("#phone").val();
        if (phone == "" || phone.length!=11) {
            alert('请正确输入家长手机号！');
            return false;
        }

        var file_obj = document.getElementById('photo').files[0];
        var formData = new FormData();
        formData.append("id",$("#user_id").val());
        formData.append("photo",file_obj);
        formData.append("name",$("#name").val());
        formData.append("card",$("#card").val());
        formData.append("age",$("#age").val());
        formData.append("sex",$("#sex").val());
        formData.append("school",$("#school").val());
        formData.append("grade",$("#grade").val());
        formData.append("class",$("#class").val());
        formData.append("phone",$("#phone").val());
        $.ajax({
            type: 'post',
            url: '/admin_user/edit',
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
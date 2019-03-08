<!DOCTYPE html>
<html>

<head>
    <title>个人中心</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

    <link rel="stylesheet" href="/css/weui.min.css">
    <link rel="stylesheet" href="/css/jquery-weui.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    body, html {
        height: 100%;
        -webkit-tap-highlight-color: transparent;
    }
    .swiper-container {
        width: 100%;
    }

    .swiper-container img {
        display: block;
        width: 100%;
    }
    .weui-form-preview__item{
        line-height: 18px;
    }
    .weui-media-box__info{
        margin-top: -3px;
    }
</style>

<body ontouchstart>

<div class="weui-tab">
    <div class="weui-tabbar">
        <a href="/activity/index" class="weui-tabbar__item">
            <span class="weui-badge" style="position: absolute;top: -.4em;right: 1em;">{{$activitys->count()}}</span>
            <div class="weui-tabbar__icon">
                <img src="/images/activity.png" alt="">
            </div>
            <p class="weui-tabbar__label">小记者活动</p>
        </a>
        <a href="/course/index" class="weui-tabbar__item">
            <div class="weui-tabbar__icon">
                <img src="/images/course.png" alt="">
            </div>
            <p class="weui-tabbar__label">核心素养课</p>
        </a>
        <a href="/acticle/index" class="weui-tabbar__item">
            <div class="weui-tabbar__icon">
                <img src="/images/acticle.png" alt="">
            </div>
            <p class="weui-tabbar__label">我要投稿</p>
        </a>
        <a href="#tab4" class="weui-tabbar__item weui-bar__item--on">
            <div class="weui-tabbar__icon">
                <img src="/images/user1.png" alt="">
            </div>
            <p class="weui-tabbar__label">个人中心</p>
        </a>
    </div>

    <div class="weui-tab__bd">

        <div id="tab4" class="weui-tab__bd-item weui-tab__bd-item--active">
            <div class="page__bd" style="margin: 20px 0 0 0;">
                <div class="weui-panel weui-panel_access" onclick="window.location.href='/user/edit?id={{$jz->id}}'">
                    <div class="weui-panel__bd">
                        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
                            <div class="weui-media-box__hd" style="width: 100px; height: 100px;">
                                <img class="weui-media-box__thumb" src="{{$jz->photo}}" style="height: 100%;width: 100%; border:2px solid #eeeeee; border-radius:50%;"  alt="">
                            </div>
                            <div class="weui-media-box__bd">
                                <h4 class="weui-media-box__title">{{$jz->name}} <br/>
                                    @if($jz->vip_type==0)
                                        小记者编号：请先成为会员
                                    @else
                                        小记者编号：{{$jz->num}}
                                    @endif
                                </h4>
                                <p class="weui-media-box__desc">
                                    学校/班级：{{$jz->school}}&nbsp{{$jz->grade}}&nbsp{{$jz->class}}
                                    <br/>手机号：{{$jz->phone}}
                                </p>
                                <p class="weui-media-box__desc">
                                    身份证号：{{$jz->card?$jz->card:'未填写'}}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="weui-panel__ft">
                <a onclick="display()" class="weui-cell weui-cell_access weui-cell_link">
                    <div class="weui-cell__bd">我的积分：{{$jz->Courses()->sum('point')+$jz->Activitys()->sum('point')+$jz->Acticles()->sum('point')+$jz->Points()->sum('point')}}</div>
                    <span class="weui-cell__ft">详情</span>
                </a>
            </div>
            <div style="display: none" id="point">
                <div class="weui-form-preview">
                    <div class="weui-panel__hd">活动积分</div>
                    <div class="weui-form-preview__hd">
                        @foreach($jz->Activitys()->get() as $v)
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{{mb_substr($v->name,0,15)}}...</label>
                                <span style="color: red">{{$v->point}}</span>
                            </div>
                        @endforeach
                            @if($jz->Activitys()->count()==0)
                                <div class="weui-form-preview__item">
                                    <label class="weui-form-preview__label">未参加活动</label>
                                </div>
                            @endif
                    </div>
                    <div class="weui-panel__hd">核心素养课积分</div>
                    <div class="weui-form-preview__hd">
                        @foreach($jz->Courses()->get() as $count)
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">《 {{$count->name}} 》</label>
                                <span style="color: red">{{$count->point}}</span>
                            </div>
                        @endforeach
                            @if($jz->Courses()->count()==0)
                                <div class="weui-form-preview__item">
                                    <label class="weui-form-preview__label">未参加核心素养课</label>
                                </div>
                            @endif
                    </div>
                    <div class="weui-panel__hd">投稿积分</div>
                    <div class="weui-form-preview__hd">
                        @foreach($jz->Acticles()->get() as $acticle)
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{{mb_substr($acticle->title,0,15)}}...</label>
                                <span style="color: red">{{$acticle->point}}</span>
                            </div>
                        @endforeach
                        @if($jz->Acticles()->count()==0)
                                <div class="weui-form-preview__item">
                                    <label class="weui-form-preview__label">未投稿</label>
                                </div>
                        @endif
                    </div>

                    <div class="weui-panel__hd">我的加分扣分</div>
                    <div class="weui-form-preview__hd">
                        @foreach($jz->Points()->get() as $point)
                            @if($point->type==1)
                                <div class="weui-panel__hd">我的活动加分扣分</div>
                                <div class="weui-form-preview__item">
                                    <label class="weui-form-preview__label">{{mb_substr($point->activity()->first()->name,0,15)}}...</label>
                                    <span style="color: red">{{$point->point}}</span><br/>
                                    <label>备注：{{$point->content}}</label>
                                </div>
                            @else
                                <div class="weui-panel__hd">我的核心素养课加分扣分</div>
                                <div class="weui-form-preview__item">
                                    <label class="weui-form-preview__label">{{mb_substr($point->course()->first()->name,0,15)}}...</label>
                                    <span style="color: red">{{$point->point}}</span><br/>
                                    <label>备注：{{$point->content}}</label>
                                </div>
                            @endif
                        @endforeach

                        @if($jz->Points()->count()==0)
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">没有加分扣分</label>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            <div class="weui-panel__ft">
                <a onclick="display1()" class="weui-cell weui-cell_access weui-cell_link">
                    <div class="weui-cell__bd">我参加的活动：{{$jz->Activitys()->count()}}</div>
                    <span class="weui-cell__ft">详情</span>
                </a>
            </div>
            <div class="weui-panel" style="display: none;" id="activity">
                <div class="weui-panel weui-panel_access">
                    <div class="weui-panel__hd">我参加的活动</div>
                    @foreach($jz->Activitys()->get() as $v)
                        <div class="weui-panel__bd">
                            <div class="weui-media-box weui-media-box_text">
                                <h3 class="weui-media-box__title">{{mb_substr($v->name,0,15)}}...
                                    @if(strtotime($v->start_time) < time())
                                        <a href="/activity/list?id={{$v->id}}" class="weui-btn weui-btn_mini weui-btn_plain-default" style="float: right">现场花絮</a>
                                    @else
                                        <button class="weui-btn weui-btn_mini weui-btn_plain-default" style="float: right">还未开始</>
                                    @endif
                                </h3>
                                <ul class="weui-media-box__info">
                                    <li class="weui-media-box__info__meta">{{date("Y-m-d H:i",strtotime($v->start_time))}}-{{date("Y-m-d H:i",strtotime($v->end_time))}}</li>
                                </ul>
                                <ul class="weui-media-box__info">
                                    <li class="weui-media-box__info__meta">实报人数/总人数</li>
                                    <li>
                                        <div class="weui-progress">
                                            {{$v->num1?$v->num1:0}}&nbsp;&nbsp;<div class="weui-progress__bar">
                                                <div class="weui-progress__inner-bar js_progress" style="width:{{($v->num1/$v->limit)*100}}%;"></div>
                                            </div>&nbsp;&nbsp;{{$v->limit}}
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                    @if($jz->Activitys()->count()==0)
                        <div class="weui-panel__bd">
                            <div class="weui-media-box weui-media-box_text">
                                还未参加活动
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="weui-panel__ft">
                <a onclick="display2()" class="weui-cell weui-cell_access weui-cell_link">
                    <div class="weui-cell__bd">我参加的课程：{{$jz->Courses()->count()}}</div>
                    <span class="weui-cell__ft">详情</span>
                </a>
            </div>
            <div class="weui-panel" style="display: none;" id="course">
                <div class="weui-panel weui-panel_access">
                    <div class="weui-panel__hd">我参加的课程</div>
                    <div class="weui-panel__ft">
                        @foreach($jz->Courses()->get() as $count)
                            <a href="/course/show?id={{$count->id}}" class="weui-cell weui-cell_access weui-cell_link">
                                <div class="weui-cell__bd">《 {{$count->name}} 》 <br><p class="weui-media-box__desc">授课教师：{{$count->teacher}}</p></div>
                                <span class="weui-cell__ft"></span>
                            </a>
                        @endforeach
                    </div>
                    @if($jz->Courses()->count()==0)
                        <div class="weui-panel__bd">
                            <div class="weui-media-box weui-media-box_text">
                                还未参加公开课
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="weui-panel__ft">
                <a onclick="display3()" class="weui-cell weui-cell_access weui-cell_link">
                    <div class="weui-cell__bd">我的投稿：{{$jz->Acticles()->count()}}</div>
                    <span class="weui-cell__ft">详情</span>
                </a>
            </div>
            <div class="weui-panel" style="display: none;" id="acticle">
                <div class="weui-panel weui-panel_access">
                    <div class="weui-panel__hd">我的投稿</div>
                    <div class="weui-panel__ft">
                        @foreach($jz->Acticles()->get() as $acticle)
                            <a href="/acticle/show?id={{$acticle->id}}" class="weui-cell weui-cell_access weui-cell_link">
                                <div class="weui-cell__bd">{{mb_substr($acticle->title,0,15)}}...</div>
                                <span class="weui-cell__ft">{{$acticle->review?'已审阅':'未审阅'}}</span>
                            </a>
                        @endforeach
                    </div>
                    @if($jz->Acticles()->count()==0)
                        <div class="weui-panel__bd">
                            <div class="weui-media-box weui-media-box_text">
                                还未投稿
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            @if($jz->vip_type==0)
                <a href="/activity/vip?id={{$jz->id}}" class="weui-btn weui-btn_primary" style="margin: 30px 0 -10px 0">成为会员</a>
            @endif
            <button onclick="logout()" class="weui-btn weui-btn_warn" style="margin: 30px 0 60px 0">解除绑定</button>
        </div>
    </div>

</div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>

<script>


    function logout(){
        $.confirm({
            title: '确定解除绑定?',
            text: '解除绑定将不能查看此小记者信息。',
            onOK: function () {
                location.href="/user/logout?id={{$jz->id}}";
            },
            onCancel: function () {
            }
        });
    }

    function display(){
        if($("#point").css('display')=='block'){
            $("#point").css('display','none');
        }else{
            $("#point").css('display','block');
        }
    }

    function display1(){
        if($("#activity").css('display')=='block'){
            $("#activity").css('display','none');
        }else{
            $("#activity").css('display','block');
        }
    }

    function display2(){
        if($("#course").css('display')=='block'){
            $("#course").css('display','none');
        }else{
            $("#course").css('display','block');
        }
    }

    function display3(){
        if($("#acticle").css('display')=='block'){
            $("#acticle").css('display','none');
        }else{
            $("#acticle").css('display','block');
        }
    }

    @if (session('success'))
    $.toptip("{{session('success')}}", 2000, 'success');  //设置显示时间
    @endif
    @if (session('error'))
    $.toptip("{{session('error')}}", 2000, 'error');  //设置显示时间
    @endif

</script>


</body>

</html>
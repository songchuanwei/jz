
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <title>活动现场</title>
    <link rel="stylesheet" type="text/css" href="/css/aui.css" />
    <link rel="stylesheet" href="/css/weui.min.css">
    <link rel="stylesheet" href="/css/jquery-weui.min.css">
    <style type="text/css">
        .text-light {
            color: #ffffff;
        }
    </style>
</head>
<body>
<section class="aui-content">
    <div class="aui-timeline">
        <div class="aui-timeline-item-header">{{mb_substr($activity->name,0,15)}}...</div>
        @foreach($news as $new)
        <div class="aui-timeline-item">
            <div class="aui-timeline-item-label aui-bg-info text-light">NO.{{$new->id}}</div>
            <div class="aui-timeline-item-inner">
                <div class="aui-card-list">
                    <div class="aui-card-list-header aui-border-b">
                        <div>{{$new->created_at}}</div>
                        <i class="aui-iconfont aui-icon-star aui-text-danger"></i>
                    </div>
                    <div class="aui-card-list-content-padded">
                        {{$new->content}}
                    </div>
                    <div class="aui-card-list-content-padded">
                        <div class="aui-row aui-row-padded">
                            @foreach(explode(",", $new->photo) as $k=>$v)
                                @if($k<count(explode(",", $new->photo))-1)
                                    <div class="aui-col-xs-4">
                                        <img src="{{$v}}" onclick="image('{{$v}}')" />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @if(count($news)<=0)
        <section class="aui-content-padded">
            <p>管理员还未添加活动花絮</p>
        </section>
        @endif
    </div>

</section>

</body>
<script type="text/javascript" src="/js/api.js" ></script>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/jquery-weui.min.js"></script>
<!-- 如果使用了某些拓展插件还需要额外的JS -->
<script src="/js/swiper.js"></script>
<script type="text/javascript">
    function image(img){
        var pb1 = $.photoBrowser({
            items: [
                img
            ]
        });
        pb1.open(2);
    }

</script>
</html>
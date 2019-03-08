<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\News;
use Config;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){

            if($message->MsgType == 'event'){
                $news = new News([
                    'title'       => '小记者属于你',
                    'description' => '欢迎关注小记者',
                    'url'         => 'http://gonggao.delin0.cn/user/index',
                    'image'       => 'http://img0.imgtn.bdimg.com/it/u=3829113245,3527265299&fm=27&gp=0.jpg',
                ]);
                return $news;
            }

        });
        return $wechat->server->serve();
    }

    public function menu_add(){
        $app = new Application(config('wechat'));

        $menu = $app->menu;

        $buttons =
            [
            [
                "name"       => "注册报名",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "如何注册",
//                        "url"  => Config::get('app.url') . "/activity/index"
                        "url"  => "http://www.baidu.com"
                    ],
                    [
                        "type" => "view",
                        "name" => "开始注册",
                        "url"  => "http://www.baidu.com"
                    ],
                ],
            ],
            [
                "name"       => "小记者之家",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "小记者简介",
                        "url"  => "http://www.baidu.com"
                    ],
                    [
                        "type" => "view",
                        "name" => "小记者积分制度",
                        "url"  => "http://www.baidu.com"
                    ],
                    [
                        "type" => "view",
                        "name" => "答家长问",
                        "url"  => "http://www.baidu.com"
                    ],
                ],
            ],
            [
                "name"       => "多重福利",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "十大景点免票",
                        "url"  => "http://www.baidu.com"
                    ],
                    [
                        "type" => "view",
                        "name" => "八大主题活动",
                        "url"  => "http://www.baidu.com"
                    ],
                    [
                        "type" => "view",
                        "name" => "五大核心素养课程",
                        "url"  => "http://www.baidu.com"
                    ],
                    [
                        "type" => "view",
                        "name" => "建立视力档案",
                        "url"  => "http://www.baidu.com"
                    ],
                    [
                        "type" => "view",
                        "name" => "活动投稿智能管理系统",
                        "url"  => "http://www.baidu.com"
                    ],
                ],
            ]

        ];
        $menu->add($buttons);
    }
}

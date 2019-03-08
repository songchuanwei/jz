<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Config;
use App\Models\User;
use App\Models\Classs;
use App\Models\Activity;
use App\Models\Course;
use App\Models\Acticle;
use DB;
use EasyWeChat\Payment\Order;
use App\Models\Pay;

class ActivityController extends Controller
{
    //投稿视图
    public function getIndex(){

        $app = new Application(config('wechat'));
        $userOpenid = session('wechat.oauth_user');  //获取用户openid
        $js = $app->js;  //微信jsSDK
        $jz=User::where('openid','=',$userOpenid['original']['openid'])->orWhere('openid1','=',$userOpenid['original']['openid'])->orWhere('openid2','=',$userOpenid['original']['openid'])->first();
        if($jz){
            $activitys=Activity::where('status','=',1)->where('end_time' ,'>=', date('Y-m-d H:i:s',time()))->orderBy('id','desc')->get();
            return view('activity/index',compact('activitys','jz'));
        }else{
            $classs=Classs::get();
            return view('user/register',['js'=>$js,'classs'=>$classs]);
        }
    }

    //近期活动详细信息
    public function getShow(Request $request){
        $userOpenid = session('wechat.oauth_user');  //获取用户openid
        $jz=User::where('openid','=',$userOpenid['original']['openid'])->orWhere('openid1','=',$userOpenid['original']['openid'])->orWhere('openid2','=',$userOpenid['original']['openid'])->first();

        $activity=Activity::find($request->id);

        $openid=$userOpenid['original']['openid'];
        //支付功能
        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => '小记者活动报名费用',
            'detail'           => '报名费用',
            'out_trade_no'     => date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8),
            'total_fee'        => $activity->money*100, // 单位：分
            'notify_url'       => 'http://gonggao.delin0.cn/activity/result', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => $openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
        $order = new Order($attributes);
        $app = new Application(config('wechat'));
        $js = $app->js;

        //判断是否是免费活动
        if($activity->money<=0){
            return view('activity/show',compact('activity','jz','js'));
        }

        $payment = $app->payment;
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){

            $prepayId = $result->prepay_id;
            $config = $payment->configForJSSDKPayment($prepayId);
            return view('activity/show',compact('activity','jz','js','config'));
        }else{
            return back()->with('error','获取支付信息失败！');
        }

    }

    //支付回调接口
    public function getResult(Request $request){
        DB::transaction(function () use ($request) {
            $activity=Activity::find($request->activity_id);
            $activity->num += 1;
            $activity->num1 += 1;
            //修改活动人数
            if(!$activity->save()){
                return redirect('/activity/show?id='.$activity->id)->with('error','报名失败');
            }

            //增加记录
            $data=$request->only(['user_id','activity_id']);
            $res=DB::table('user_activity')->insert($data);
            if(!$res){
                return redirect('/activity/show?id='.$activity->id)->with('error','报名失败');
            }

            $app = new Application(config('wechat'));
            $notice = $app->notice;
            $userOpenid = session('wechat.oauth_user');  //获取用户openid
            $userId = $userOpenid['original']['openid'];
            $templateId = '-Cgy5aTMK5Dt6DYHBNwTvlNsnTu-XM-YCdbCkb8z_bw';
            $url = config('app.url').'/activity/show?id='.$request->activity_id;
            $data = array(
                "first"  => '您好小记者，您已报名活动，请及时参加！',
                "keyword1"  => $activity->name,
                "keyword2"  => date('Y-m-d H:i',strtotime($activity->start_time)),
                "keyword3"  => $activity->start_location,
                "remark"   => '一起玩，就是这么嗨。',
            );
            @$notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

            //增加支付记录 （收费活动加记录）
            if($activity->money>0){
                $data1['user_id']=$request->user_id;
                $data1['type']=$activity->name;
                $data1['num']=$activity->money;
                $data1['pay_type']=1;
                $res1=Pay::create($data1);
                if(!$res1){
                    return redirect('/activity/show?id='.$activity->id)->with('error','报名失败');
                }
            }
        });
        //修改成功 返回上一级界面
        return redirect('/activity/show?id='.$request->activity_id)->with('success','报名成功，请及时参加活动！');
    }

    //正在进行活动信息
    public function getList(Request $request){
        $activity=Activity::find($request->id);
        $news=DB::table('activity_new')->where('activity_id','=',$request->id)->get();
        return view('activity/list',compact('news','activity'));
    }

    //成为会员
    public function getVip(Request $request){
        $id=$request->id;

        $userOpenid = session('wechat.oauth_user');  //获取用户openid
        $openid=$userOpenid['original']['openid'];
        //会员价格
        $num=DB::table('vip')->first();
        //支付功能
        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => '小记者VIP报名费用',
            'detail'           => '成为小记者费用',
            'out_trade_no'     => date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8),
            'total_fee'        => (int)($num->num*100), // 单位：分
            'notify_url'       => 'http://gonggao.delin0.cn/activity/result1', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => $openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
        ];
        $order = new Order($attributes);
        $app = new Application(config('wechat'));
        $js = $app->js;
        $payment = $app->payment;
        $result = $payment->prepare($order);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){

            $prepayId = $result->prepay_id;
            $config = $payment->configForJSSDKPayment($prepayId);
            return view('user.vip',compact('id','js','config'));
        }else{
            return back()->with('error','获取支付信息失败！');
        }
    }
    //支付回调接口
    public function getResult1(Request $request){
        DB::transaction(function () use ($request) {
            $user=User::find($request->id);
            $user->vip_type=1;
            $user->pay_type=1;
            if($user->id<100){
                if($user->id<10){
                    $user->num='2019100'.$user->id;
                }else{
                    $user->num='201910'.$user->id;
                }
            }else{
                $user->num='20191'.$user->id;
            }
            if(!$user->save()){
                return redirect('/activity/vip?id='.$user->id)->with('error','成为会员失败');
            }

            //增加支付记录
            $data1['user_id']=$user->id;
            $data1['type']='会员';
            $data1['num']=config('app.vip_money');
            $data1['pay_type']=1;
            $res1=Pay::create($data1);
            if(!$res1){
                return redirect('/activity/vip?id='.$user->id)->with('error','成为会员失败');
            }

        });
        //修改成功 返回上一级界面
        return redirect('/user/index')->with('success','恭喜你成为小记者！');
    }


}

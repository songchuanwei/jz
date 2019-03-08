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

class ActicleController extends Controller
{
    //投稿视图
    public function getIndex(){

        $app = new Application(config('wechat'));
        $userOpenid = session('wechat.oauth_user');  //获取用户openid
        $js = $app->js;  //微信jsSDK
        $jz=User::where('openid','=',$userOpenid['original']['openid'])->orWhere('openid1','=',$userOpenid['original']['openid'])->orWhere('openid2','=',$userOpenid['original']['openid'])->first();
        if($jz){
            $activitys=Activity::where('status','=',1)->where('end_time' ,'>=', date('Y-m-d H:i:s',time()))->orderBy('id','desc')->get();

            return view('acticle/index',compact('activitys','js','jz'));
        }else{
            $classs=Classs::get();
            return view('user/register',['js'=>$js,'classs'=>$classs]);
        }
    }

    //处理提交稿件
    public function postCreate(Request $request){
        $userOpenid = session('wechat.oauth_user');  //获取用户openid
        $jz=User::where('openid','=',$userOpenid['original']['openid'])->orWhere('openid1','=',$userOpenid['original']['openid'])->orWhere('openid2','=',$userOpenid['original']['openid'])->first();
        $data=$request->only(['title','content','photo']);
        $data['user_id']=$jz->id;
        $acticle=new Acticle;
        if($acticle->create($data)){
            return redirect('/acticle/index')->with('success','投稿成功！');
        }else{
            return back()->with('success','投稿失败！');
        }
    }

    //处理提交稿件
    public function getShow(Request $request){
        $acticle=Acticle::findOrFail($request->id);
        return view('acticle/show',compact('acticle'));
    }



}

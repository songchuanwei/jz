<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Config;
use Storage;
use App\Models\User;
use App\Models\Classs;
use App\Models\Activity;
use App\Models\Course;
use App\Models\Acticle;
use EasyWeChat\Payment\Order;
use App\Models\Pay;

class UsersController extends Controller
{

    //处理openid 不存在绑定
    public function getIndex(){

        $app = new Application(config('wechat'));
        $userOpenid = session('wechat.oauth_user');  //获取用户openid
        $js = $app->js;  //微信jsSDK
        $jz=User::where('openid','=',$userOpenid['original']['openid'])->orWhere('openid1','=',$userOpenid['original']['openid'])->orWhere('openid2','=',$userOpenid['original']['openid'])->first();
        if($jz){
            $activitys=Activity::where('status','=',1)->where('end_time' ,'>=', date('Y-m-d H:i:s',time()))->orderBy('id','desc')->get();

            return view('user/index',compact('activitys','jz'));
        }else{
            $classs=Classs::get();
            return view('user/register',['js'=>$js,'classs'=>$classs]);
        }
    }

    //个人详细信息界面
    public function getMy(Request $request){
        $jz=User::findOrFail($request->id);

        return view('user/my',['jz'=>$jz]);
    }

    //编辑个人信息界面
    public function getEdit(Request $request){
        $app = new Application(config('wechat'));
        $js = $app->js;  //微信jsSDK
        $jz=User::findOrFail($request->id);
        $classs=Classs::get();
        return view('user/edit',compact('jz','js','classs'));
    }

    //处理编辑个人信息
    public function postEdit(Request $request){
        $jz=User::findOrFail($request->user_id);
        $jz->name=$request->name;
        $jz->age=$request->age;
        $jz->sex=$request->sex;
        $jz->phone=$request->phone;
        $jz->card=$request->card;
        $jz->photo=$request->photo;
        $grade=explode(' ',$request->class);
        $jz->school=$grade[0];
        $jz->grade=$grade[1];
        $jz->class=$grade[2];
        if($jz->save()){
            return redirect('/user/my?id='.$jz->id)->with('success','小记者信息修改成功');
        }else{
            return back()->with('error','小记者信息修改失败');
        }
    }

    //注册界面
    public function getRegister(){
        $app = new Application(config('wechat'));
        $js = $app->js;  //微信jsSDK
        $classs=Classs::get();
        return view('user/register',['js'=>$js,'classs'=>$classs]);
    }

    //处理注册
    public function postBinding(Request $request){
        $request->flashOnly('name','age','phone','card','photo','class');
        $user=new User;
        $data=$request->only(['name','sex','age','card','phone','photo']);
        $grade=explode(' ',$request->class);
        $data['school']=$grade[0];
        $data['grade']=$grade[1];
        $data['class']=$grade[2];

        $userZj=User::where('name','=',$request->name)
            ->where('sex','=',$request->sex)
            ->where('school','=',$grade[0])
            ->where('grade','=',$grade[1])
            ->where('class','=',$grade[2])
            ->first();
        if(!$userZj){
            $userOpenid = session('wechat.oauth_user');  //获取用户openid
            $data['openid']=$userOpenid['original']['openid'];

            if($user->create($data)){
                return redirect('/activity/index')->with('success','小记者注册成功');
            }else{
                return back()->with('error','注册失败');
            }
        }else{
            return back()->with('error','此小记者已经是会员，请前往绑定小记者信息!');
        }
    }

    //处理登陆
    public function postLogin(Request $request){
        $request->flashOnly('name_login', 'num');
        $user=User::where('name','=',$request->name_login)->first();
        if($user){
            if($user->num==trim($request->num)){
                $userOpenid = session('wechat.oauth_user');  //获取用户openid
                if(empty($user->openid)){
                    $user->openid=$userOpenid['original']['openid'];
                }else{
                    if(empty($user->openid1)){
                        $user->openid1=$userOpenid['original']['openid'];
                    }else{
                        if(empty($user->openid2)){
                            $user->openid2=$userOpenid['original']['openid'];
                        }else{
                            return back()->with('error','此小记者最多有三个微信号登陆！');
                        }
                    }
                }
                $user->save();
                return redirect('/activity/index')->with('success','登陆成功');
            }else{
                return back()->with('error','小记者编号错误！');
            }
        }else{
            return back()->with('error','没有此小记者信息，请先注册成为小记者 ！');
        }
    }

    //我的总积分
    public function getPoint(Request $request){
        $jz=User::findOrFail($request->id);
        //小记者的投稿
        $acticles=$jz->Acticles()->get();
        //小记者已参加活动
        $activitys=$jz->Activitys()->get();
        //小记者已参加公开课
        $courses=$jz->Courses()->get();
        return view('user.point',compact('acticles','activitys','courses'));

    }


    //解除绑定
    public function getLogout(Request $request){
        $jz=User::findOrFail($request->id);
        $userOpenid = session('wechat.oauth_user');  //获取用户openid
        if($userOpenid['original']['openid']==$jz->openid2){
            $jz->openid2=NULL;
        }
        if($userOpenid['original']['openid']==$jz->openid1){
            $jz->openid1=NULL;
        }
        if($userOpenid['original']['openid']==$jz->openid){
            $jz->openid=NULL;
        }
        if($jz->save()){
            return redirect('/user/index')->with('success','解除绑定成功');
        }else{
            return back()->with('error','解除绑定失败');
        }
    }

    //我参加的活动列表
    public function getCountactivity(Request $request){
        $jz=User::findOrFail($request->user_id);
        return view('user.activity',compact('jz'));
    }
    //我参加的公开课
    public function getCountcourse(Request $request){
        $jz=User::findOrFail($request->user_id);
        return view('user.course',compact('jz'));
    }

    //保存从微信服务器获取的图片
    public function postSaveimg(Request $request)
    {
        $media_id=$request->input('serverId');
        $app = new Application(config('wechat'));

        // 获取 access token 实例
        $accessToken = $app->access_token;
        $token = $accessToken->getToken(); // token 字符串
        $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$token."&media_id=".$media_id;
        //上传路径
        $path='/uploads/user/'.date('Ymd',time()).'/';
        $filename=$path.time().'.jpg';
        //将图片移动至public目录
        if(Storage::put($filename, file_get_contents($url))){
            echo json_encode(['errno'=>0,'url'=>$filename]);
        }else{
            echo json_encode(['errno'=>1,'url'=>$filename]);
        }
    }
}

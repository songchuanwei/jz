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

class CourseController extends Controller
{
    //公开课详细信息
    //投稿视图
    public function getIndex(){

        $app = new Application(config('wechat'));
        $userOpenid = session('wechat.oauth_user');  //获取用户openid
        $js = $app->js;  //微信jsSDK
        $jz=User::where('openid','=',$userOpenid['original']['openid'])->orWhere('openid1','=',$userOpenid['original']['openid'])->orWhere('openid2','=',$userOpenid['original']['openid'])->first();
        if($jz){
            $activitys=Activity::where('status','=',1)->where('end_time' ,'>=', date('Y-m-d H:i:s',time()))->orderBy('id','desc')->get();
            $courses=Course::where('status','=',1)->orderBy('id','desc')->get();
            return view('course/index',compact('activitys','courses','jz'));
        }else{
            $classs=Classs::get();
            return view('user/register',['js'=>$js,'classs'=>$classs]);
        }
    }

    //公开课详细信息
    public function getShow(Request $request){
        $userOpenid = session('wechat.oauth_user');  //获取用户openid

        $course=Course::find($request->id);
        $jz=User::where('openid','=',$userOpenid['original']['openid'])->orWhere('openid1','=',$userOpenid['original']['openid'])->orWhere('openid2','=',$userOpenid['original']['openid'])->first();
        //此小记者选的所有公开课
        $countCourse=$jz->Courses()->count();
        //此小记者是否选了此公开课
        $hasCourse=$jz->hasCourse($request->id);

        return view('course/show',compact('course','jz','hasCourse','countCourse'));
    }

    //核心素养课报名
    public function getJoin(Request $request){
        DB::transaction(function () use ($request) {
            $course=Course::find($request->course_id);
            $course->num += 1;
            $course->num1 += 1;
            if(!$course->save()){
                return ['error'=>1,'msg'=>'报名失败'];
            }
            $data=$request->only(['user_id','course_id']);
            $res=DB::table('user_course')->insert($data);
            if(!$res){
                return ['error'=>1,'msg'=>'报名失败'];
            }

            $app = new Application(config('wechat'));
            $notice = $app->notice;
            $userOpenid = session('wechat.oauth_user');  //获取用户openid
            $userId = $userOpenid['original']['openid'];
            $templateId = '-Cgy5aTMK5Dt6DYHBNwTvlNsnTu-XM-YCdbCkb8z_bw';
            $url = config('app.url').'/course/show?id='.$request->course_id;
            $data = array(
                "first"  => '您好小记者，您已报名核心素养课，请及时参加！',
                "keyword1"  => '《'.$course->name.'》',
                "keyword2"  => $course->time?date('Y-m-d H:i',strtotime($course->time)):'时间待定',
                "keyword3"  => $course->location?$course->location:'地点待定',
                "remark"   => '一起学习，共同进步。',
            );
            @$notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();

        });
        return ['error'=>0,'msg'=>'报名成功'];

    }


}

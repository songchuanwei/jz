<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\Course;
use App\Models\User_point;
use App\Models\Classs;
use EasyWeChat\Foundation\Application;
use Config;

class CourseController extends Controller
{

    public function getIndex(Request $request)
    {
        $courses=Course::orderBy('id','desc')->where(
            function($query) use ($request){
                if(!empty($request->title)){
                    $query->where('name', 'like', '%'.$request->title.'%')
                        ->orWhere('content', 'like', '%'.$request->title.'%')
                        ->orWhere('teacher', 'like', '%'.$request->title.'%');
                }
            }
        )->paginate(10);
        return view('admin.course.index',compact('courses'));
    }

    public function getAdd(){
        return view('admin.course.add');
    }
    public function postAdd(Request $request){
        $data=$request->only(['name','teacher','point','limit','grade','time','location','content','teacher_info']);

        $destinationPath='./uploads/course/' . date('Ymd');
        $aa=$request->file('photo');
        $suffix=$aa->getClientOriginalExtension();
        $fileName=time().rand(10000,999999).'.'.$suffix;
        $aa->move($destinationPath, $fileName);
        $data['photo']=trim($destinationPath . '/' . $fileName, '.');

        $data['status']=1;
        $data['num']=0;
        $res=Course::create($data);
        if($res){
            return ['error'=>0,'msg'=>'添加成功'];
        }else{
            return ['error'=>1,'msg'=>'添加失败'];
        }
    }

    public function getEdit(Request $request){
        $grades=['一年级','二年级','三年级','四年级','五年级','六年级'];
        $course=Course::findOrFail($request->id);
        return view('admin.course.edit',compact('course','grades'));
    }
    public function postEdit(Request $request){
        $course=Course::find($request->id);
        $course->name=$request->name;
        $course->teacher=$request->teacher;
        $course->point=$request->point;
        $course->grade=$request->grade;
        $course->num1=$request->num1;
        $course->limit=$request->limit;
        $course->time=$request->time;
        $course->location=$request->location;
        $course->content=$request->content;
        $course->teacher_info=$request->teacher_info;
        $course->status=$request->status;
        $course->updated_at=date('Y-m-d H:i:s',time());
        //是否修改头像
        if($request->hasFile('photo')) {
            $destinationPath='./uploads/adminUser/' . date('Ymd');
            $aa=$request->file('photo');
            $suffix=$aa->getClientOriginalExtension();
            $fileName=time().rand(10000,999999).'.'.$suffix;
            $aa->move($destinationPath, $fileName);
            $course->photo=trim($destinationPath . '/' . $fileName, '.');
        }
        if($course->save()){
            return ['error'=>0,'msg'=>'修改成功'];
        }else{
            return ['error'=>1,'msg'=>'修改失败'];
        }
    }

    public function getDel(Request $request){
        $course=Course::findOrFail($request->id);
        if($course->delete()){
            return ['ennor'=>0,'msg'=>'删除成功'];
        }else{
            return ['ennor'=>1,'msg'=>'删除失败'];
        }
    }

    //发送模板消息
    public function getXinxi(Request $request){
        $schools=Classs::get();
        $grades=['一年级','二年级','三年级','四年级','五年级','六年级'];
        $classs=['1班','2班','3班','4班','5班','6班','7班','8班','9班','10班'];
        $course=Course::findOrFail($request->id);
        return view('admin.course.xinxi',compact('schools','grades','classs','course'));
    }
    public function postXinxi(Request $request){
        $course=Course::findOrFail($request->id);

        if($request->school=='1'){
            if($request->grade=='1'){
                if($request->class1=='1'){
                    $jzs=$course->users()->get();
                }else{
                    $jzs=$course->users()->where('class','=',$request->class1)->get();
                }
            }else{
                if($request->class1=='1'){
                    $jzs=$course->users()->where('grade','=',$request->grade)->get();
                }else{
                    $jzs=$course->users()->where('grade','=',$request->grade)->where('class','=',$request->class1)->get();
                }
            }
        }else{
            if($request->grade=='1'){
                if($request->class1=='1'){
                    $jzs=$course->users()->where('school','=',$request->school)->get();
                }else{
                    $jzs=$course->users()->where('school','=',$request->school)->where('class','=',$request->class1)->get();
                }
            }else{
                if($request->class1=='1'){
                    $jzs=$course->users()->where('school','=',$request->school)->where('grade','=',$request->grade)->get();
                }else{
                    $jzs=$course->users()->where('school','=',$request->school)->where('grade','=',$request->grade)->where('class','=',$request->class1)->get();
                }
            }
        }

        $openids=[];
        foreach ($jzs as $jz){
            if(!empty($jz->openid2)){
                array_push($openids,$jz->openid2);
            }
            if(!empty($jz->openid1)){
                array_push($openids,$jz->openid1);
            }
            if(!empty($jz->openid)){
                array_push($openids,$jz->openid);
            }
        }

        //发送模板消息
        $app = new Application(config('wechat'));
        $notice = $app->notice;
        foreach ($openids as $k=>$v){
            $userId = $v;
            $templateId = '-Cgy5aTMK5Dt6DYHBNwTvlNsnTu-XM-YCdbCkb8z_bw';
            $url = config('app.url').'/course/show?id='.$course->id;
            $data = array(
                "first"  => '您好，你报名的公开课开始啦！',
                "keyword1"  => '《'.$course->name.'》',
                "keyword2"  => $request->time?$request->time:date('Y-m-d H:i',strtotime($course->time)),
                "keyword3"  => $request->location?$request->location:$course->location,
                "remark"   => '一起学习，就是这么嗨。',
            );

            $userService = $app->user;
            $user=$userService->get($v);
            if($user->subscribe==1){
                @$notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
            }
        }
        return ['error'=>0,'msg'=>'发送模板消息成功'];
    }

    //活动报名小记者
    public function getUser(Request $request){
        $courses=Course::orderBy('id','desc')->get();

        if(empty($request->course)){
            $course=Course::orderBy('id','desc')->first();
        }else{
            $course=Course::findOrFail($request->course);
        }

        return view('admin.course.user',compact('courses','course'));
    }
    //活动报名小记者加减分
    public function postUserpoint(Request $request){
        $data=$request->only(['point','content','user_id','point_id','type']);
        $res=User_point::firstOrCreate($data);
        if($res){
            return ['error'=>0,'msg'=>'打分成功'];
        }else{
            return ['error'=>1,'msg'=>'打分失败'];
        }
    }

}

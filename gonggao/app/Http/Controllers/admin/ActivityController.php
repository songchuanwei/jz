<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\Activity;
use App\Models\User_point;
use App\Models\Classs;
use DB;
use EasyWeChat\Foundation\Application;
use Config;
use App\Handlers\ImageUploadHandler;

class ActivityController extends Controller
{

    public function getIndex(Request $request)
    {
        $activitys=Activity::orderBy('id','desc')->where(
                                    function($query) use ($request){
                                        if(!empty($request->title)){
                                            $query->where('name', 'like', '%'.$request->title.'%')
                                                ->orWhere('start_location', 'like', '%'.$request->title.'%')
                                                ->orWhere('end_location', 'like', '%'.$request->title.'%');
                                        }
                                    }
                                )->paginate(10);
        return view('admin.activity.index',compact('activitys'));
    }

    public function getAdd(){
        return view('admin.activity.add');
    }
    public function postAdd(Request $request){
        $data=$request->only(['name','money','point','limit','start_time','end_time','start_location','end_location','arrange']);
        $data['status']=1;
        $data['num']=0;
        $res=Activity::create($data);
        if($res){
            return ['error'=>0,'msg'=>'添加成功'];
        }else{
            return ['error'=>1,'msg'=>'添加失败'];
        }
    }

    public function getEdit(Request $request){
        $activity=Activity::findOrFail($request->id);
        return view('admin.activity.edit',compact('activity'));
    }
    public function postEdit(Request $request){
        $activity=Activity::find($request->id);
        $activity->name=$request->name;
        $activity->money=$request->money;
        $activity->point=$request->point;
        $activity->num1=$request->num1;
        $activity->limit=$request->limit;
        $activity->start_time=$request->start_time;
        $activity->end_time=$request->end_time;
        $activity->start_location=$request->start_location;
        $activity->end_location=$request->end_location;
        $activity->arrange=$request->arrange;
        $activity->status=$request->status;
        $activity->updated_at=date('Y-m-d H:i:s',time());
        if($activity->save()){
            return ['error'=>0,'msg'=>'修改成功'];
        }else{
            return ['error'=>1,'msg'=>'修改失败'];
        }
    }

    public function getDel(Request $request){
        $activity=Activity::findOrFail($request->id);
        if($activity->delete()){
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
        $activity=Activity::findOrFail($request->id);
        return view('admin.activity.xinxi',compact('schools','grades','classs','activity'));
    }
    public function postXinxi(Request $request){
        $activity=Activity::findOrFail($request->id);
        if($request->school=='1'){
            if($request->grade=='1'){
                if($request->class1=='1'){
                    $jzs=$activity->users()->get();
                }else{
                    $jzs=$activity->users()->where('class','=',$request->class1)->get();
                }
            }else{
                if($request->class1=='1'){
                    $jzs=$activity->users()->where('grade','=',$request->grade)->get();
                }else{
                    $jzs=$activity->users()->where('grade','=',$request->grade)->where('class','=',$request->class1)->get();
                }
            }
        }else{
            if($request->grade=='1'){
                if($request->class1=='1'){
                    $jzs=$activity->users()->where('school','=',$request->school)->get();
                }else{
                    $jzs=$activity->users()->where('school','=',$request->school)->where('class','=',$request->class1)->get();
                }
            }else{
                if($request->class1=='1'){
                    $jzs=$activity->users()->where('school','=',$request->school)->where('grade','=',$request->grade)->get();
                }else{
                    $jzs=$activity->users()->where('school','=',$request->school)->where('grade','=',$request->grade)->where('class','=',$request->class1)->get();
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
            $url = config('app.url').'/activity/show?id='.$activity->id;
            $data = array(
                "first"  => '您好，你报名的活动开始啦！',
                "keyword1"  => $activity->name,
                "keyword2"  => $request->time?$request->time:date('Y-m-d H:i',strtotime($activity->start_time)),
                "keyword3"  => $request->location?$request->location:$activity->start_location,
                "remark"   => '一起玩，就是这么嗨。',
            );
            $userService = $app->user;
            $user=$userService->get($v);
            if($user->subscribe==1){
                @$notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
            }

        }
        return ['error'=>0,'msg'=>'发送模板消息成功'];
    }

    //活动现场
    public function getNew(Request $request){
        $activitys=Activity::where('start_time','<=',date('Y-m-d H:i:s',time()))->orderBy('id','desc')->get();

        $news=DB::table('activity_new')->orderBy('id','desc')->where(
            function($query) use ($request){
                if(!empty($request->segment)){
                    $query->where('activity_id', '=',$request->segment);
                }
            }
        )->paginate(10);
        foreach ($news as $new){
            $activity_name=Activity::select('name')->findOrFail($new->activity_id);
            $new->activity_name=$activity_name['name'];
        }
        $segment=$request->segment==''?$activitys[0]->id:$request->segment;

        return view('admin.activity.new',compact('news','activitys','segment'));
    }

    public function getNewadd(){
        $activitys=Activity::where('start_time','<=',date('Y-m-d H:i:s',time()))->orderBy('id','desc')->get();
        return view('admin.activity.newadd',compact('activitys'));
    }
    public function postNewadd(Request $request){
        $data=$request->only(['content','activity_id']);
        $data['photo']='';
        //是否修改头像
        $aa = $request->photo;
        if($aa) {
            $destinationPath = './uploads/newActivity/' . date('Ymd');
            foreach ($aa as $v) {
                //获取后缀
                $suffix = $v->getClientOriginalExtension();
                $fileName = time() . rand(10000, 999999) . '.' . $suffix;
                $v->move($destinationPath, $fileName);
                $data['photo'] .= trim($destinationPath . '/' . $fileName, '.') . ',';
            }
        }
        $data['created_at']=date('Y-m-d H:i:s',time());
        $data['updated_at']=date('Y-m-d H:i:s',time());
        $res=DB::table('activity_new')->insert($data);
        if($res){
            return ['error'=>0,'msg'=>'添加成功'];
        }else{
            return ['error'=>1,'msg'=>'添加失败'];
        }
    }

    public function getNewdel(Request $request){
        $new_activity=DB::table('activity_new')->where('id', '=', $request->id)->delete();
        if($new_activity){
            return ['ennor'=>0,'msg'=>'删除成功'];
        }else{
            return ['ennor'=>1,'msg'=>'删除失败'];
        }
    }


    //活动报名小记者
    public function getUser(Request $request){
        $activitys=Activity::orderBy('id','desc')->get();

        if(empty($request->activity)){
            $activity=Activity::orderBy('id','desc')->first();
        }else{
            $activity=Activity::findOrFail($request->activity);
        }

        return view('admin.activity.user',compact('activitys','activity'));
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


    //上传文件api
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }



}

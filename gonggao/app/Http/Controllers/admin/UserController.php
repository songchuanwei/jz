<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Classs;
use App\Models\Activity;
use App\Models\Pay;
use App\Models\User_file;
use DB;
use Excel;
use Config;
use EasyWeChat\Foundation\Application;

class UserController extends Controller
{

    protected $allowed_ext = ["xlsx", "xls"]; //限制上传立案文档格式

    public function getIndex(Request $request)
    {
        $schools=Classs::get();
        $grades=['一年级','二年级','三年级','四年级','五年级','六年级'];
        $classs=['1班','2班','3班','4班','5班','6班','7班','8班','9班','10班','11班','12班','13班','14班','15班'];
        $users=User::orderBy('id','desc')->where(
            function($query) use ($request){
                if($request->school && $request->grade && $request->class){

                    if($request->school=='所有'){
                        if($request->grade=='所有'){
                            if($request->class!='所有'){
                                $query->where('class', '=',$request->class);
                            }
                        }else{
                            if($request->class=='所有'){
                                $query->where('grade', '=',$request->grade);
                            }else{
                                $query->where('grade', '=',$request->grade)->where('class', '=',$request->class);
                            }
                        }
                    }else{
                        if($request->grade=='所有'){
                            if($request->class=='所有'){
                                $query->where('school', '=',$request->school);
                            }else{
                                $query->where('class', '=',$request->class)->where('school', '=',$request->school);
                            }
                        }else{
                            if($request->class=='所有'){
                                $query->where('grade', '=',$request->grade)->where('school', '=',$request->school);
                            }else{
                                $query->where('grade', '=',$request->grade)->where('class', '=',$request->class)->where('school', '=',$request->school);
                            }
                        }
                    }

                }
            }
        )->paginate(10);
        return view('admin.user.index',compact('users','schools','grades','classs','request'));
    }

    public function postExcel(Request $request){   //上传学生excel文件
        if ($request->hasFile('excel')) {

            $destinationPath='./uploads/user_file/' . date('Ymd');
            $aa=$request->file('excel');
            $suffix=$aa->getClientOriginalExtension();
            if (!in_array($suffix, $this->allowed_ext)) {   //判断文档类型
                return ['error'=>1,'msg'=>'文件类型不正确。'];
            }
            $fileName=time().rand(10000,999999).'.'.$suffix;

            $data=[];
            Excel::selectSheetsByIndex(0)->load($aa,function($reader) use ($data){
                $students=$reader->noHeading()->all(); //这一句
                foreach ($students as $k=>$v) {
                    if($k>0){
                        $data=['name'=>$v[0],'card'=>$v[1],'age'=>$v[2],'sex'=>$v[3],'school'=>$v[4],'grade'=>$v[5],'class'=>$v[6],'phone'=>$v[7],'vip_type'=>1,'pay_type'=>0];

                        DB::transaction(function () use ($data) {
                            $res=User::firstOrCreate($data);
                            if(!$res->save()){
                                return ['error'=>1,'msg'=>$res->name.'添加失败'];
                            }else{
                                $user=User::findOrFail($res->id);
                                if($user->id<100){
                                    if($user->id<10){
                                        $user->num='2019000'.$user->id;
                                    }else{
                                        $user->num='201900'.$user->id;
                                    }
                                }else{
                                    $user->num='20190'.$user->id;
                                }
                                if(!$user->save()){
                                    return ['error'=>1,'msg'=>$res->name.'修改会员失败'];
                                }
                            }

                        });

                    }
                }

            });

            $aa->move($destinationPath, $fileName);
            $data1['admin_id']=Auth::user()->id;
            $data1['upload']=trim($destinationPath . '/' . $fileName, '.');
            $res=User_file::create($data1);
            //储存文件
            if(!$res){
                return ['error'=>1,'msg'=>'文件储存失败。'];
            }

            return ['error'=>0,'msg'=>'上传成功'];

        }else{
            return ['error'=>1,'msg'=>'没有学生文件上传。'];
        }

    }

    //导出特定小记者信息
    public function getExcelput(Request $request){  //导出题库表
        ini_set('memory_limit','500M');
        $users = User::where('vip_type','=',1)->where(
            function($query) use ($request){
                if($request->school && $request->grade && $request->class){

                    if($request->school=='所有'){
                        if($request->grade=='所有'){
                            if($request->class!='所有'){
                                $query->where('class', '=',$request->class);
                            }
                        }else{
                            if($request->class=='所有'){
                                $query->where('grade', '=',$request->grade);
                            }else{
                                $query->where('grade', '=',$request->grade)->where('class', '=',$request->class);
                            }
                        }
                    }else{
                        if($request->grade=='所有'){
                            if($request->class=='所有'){
                                $query->where('school', '=',$request->school);
                            }else{
                                $query->where('class', '=',$request->class)->where('school', '=',$request->school);
                            }
                        }else{
                            if($request->class=='所有'){
                                $query->where('grade', '=',$request->grade)->where('school', '=',$request->school);
                            }else{
                                $query->where('grade', '=',$request->grade)->where('class', '=',$request->class)->where('school', '=',$request->school);
                            }
                        }
                    }

                }
            }
        )->select('num','name','card','age','sex','school','grade','class','phone','photo')->get()->toArray();

        $celldata=[['小记者编号','姓名','身份证号','年龄','性别','家长手机号','学校/年级/班级','头像']];
        $celldata1=[];

        foreach ($users as $k=>$v){
            $celldata1[$k][0]=$v['num'];
            $celldata1[$k][1]=$v['name'];
            $celldata1[$k][2]=$v['card']?(string)$v['card']:'未填写';
            $celldata1[$k][3]=$v['age'];
            $celldata1[$k][4]=$v['sex'];
            $celldata1[$k][5]=$v['phone'];
            $celldata1[$k][6]=$v['school'].'/'.$v['grade'].'/'.$v['class'];
            $celldata1[$k][7]=$v['photo'];
        }

        Excel::create('小记者信息'.time(), function ($excel) use ($celldata, $celldata1) {
            $excel->sheet('score', function ($sheet) use ($celldata, $celldata1) {
                $title_array = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q',
                    'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH'];

                $sheet->rows($celldata);
                foreach ($celldata1 as $key => $item) {
                    foreach ($item as $k => $img) {
                        if($k == 7 && !empty($img)) {
                            $objDrawing = new \PHPExcel_Worksheet_Drawing();
                            $v = public_path($img); //拼接图片地址
                            $objDrawing->setPath( $v );
                            $sp = $title_array[$k];
                            $objDrawing->setCoordinates( $sp . ($key+2) );
                            $sheet->setHeight($key+2, 100); //设置高度
                            $sheet->setWidth(array( $sp =>30));  //设置宽度

                            //限定图片高度
                            $objDrawing->setHeight(100);
                            //图片在单元格中的偏移位置(若不设置则图位于单元格左上方)
                            $objDrawing->setOffsetX(10);
                            $objDrawing->setOffsetY(10);
                            $objDrawing->setRotation(100);
                            $objDrawing->setWorksheet($sheet);

                        }else{
                            $sheet->cell($title_array[$k] . ($key+2), function ($cell) use ($img) {
                                $cell->setValue($img);
                            });
                            $sheet->setWidth(array( $title_array[$k] =>30));  //设置宽度
                        }
                    }
                }

                //设置单元格样式(第一行为title)
                $setCount = count($celldata)+1;
                for ($c = 2; $c < $setCount; $c++) {
                    $sheet->setHeight([//设置第二行起每一行的高度
                        $c => 100,
                    ]);
                }

                //设置每一行宽度
                $sheet->setWidth([
                    'A' => 15,
                    'B' => 15,
                ]);

                //计算总数据量
                $count = count($celldata);
                $sheet->cells("A1:R$count", function ($cells) {
                    //设置单元格内元素靠左向上
                    $cells->setAlignment('left');
                    $cells->setValignment('top');
                });
                //标题加粗
                $sheet->cells("A1:S1", function ($cells) {
                    $cells->setFontWeight('bold');
                });
            });
        })->export('xls');
        die;
    }

    public function getAdd(){
        $classs=Classs::get();
        return view('admin.user.add',compact('classs'));
    }
    public function postAdd(Request $request){
        $data=$request->only(['name','card','age','sex','school','grade','class','phone']);

        $destinationPath='./uploads/adminUser/' . date('Ymd');
        $aa=$request->file('photo');
        $suffix=$aa->getClientOriginalExtension();
        $fileName=time().rand(10000,999999).'.'.$suffix;
        $aa->move($destinationPath, $fileName);
        $data['photo']=trim($destinationPath . '/' . $fileName, '.');

        $res=User::create($data);
        if($res){
            return ['error'=>0,'msg'=>'添加成功'];
        }else{
            return ['error'=>1,'msg'=>'添加失败'];
        }
    }

    public function getEdit(Request $request){
        $schools=Classs::get();
        $grades=['一年级','二年级','三年级','四年级','五年级','六年级'];
        $classs=['1班','2班','3班','4班','5班','6班','7班','8班','9班','10班','11班','12班','13班','14班','15班'];
        $user=User::findOrFail($request->id);
        return view('admin.user.edit',compact('user','schools','grades','classs'));
    }
    public function postEdit(Request $request){
        $user=User::find($request->id);
        $user->name=$request->name;
        $user->card=$request->card;
        $user->age=$request->age;
        $user->sex=$request->sex;
        $user->school=$request->school;
        $user->grade=$request->grade;
        $user->class=$request->class;
        $user->phone=$request->phone;
        //是否修改头像
        if($request->hasFile('photo')) {
            $destinationPath='./uploads/adminUser/' . date('Ymd');
            $aa=$request->file('photo');
            $suffix=$aa->getClientOriginalExtension();
            $fileName=time().rand(10000,999999).'.'.$suffix;
            $aa->move($destinationPath, $fileName);
            $user->photo=trim($destinationPath . '/' . $fileName, '.');
        }

        $user->updated_at=date('Y-m-d H:i:s',time());
        if($user->save()){
            return ['error'=>0,'msg'=>'修改成功'];
        }else{
            return ['error'=>1,'msg'=>'修改失败'];
        }
    }

    public function getDel(Request $request){
        $user=User::findOrFail($request->id);
        if($user->delete()){
            return ['ennor'=>0,'msg'=>'删除成功'];
        }else{
            return ['ennor'=>1,'msg'=>'删除失败'];
        }
    }

    //小记者缴费
    public function getPay(Request $request){
        $user=User::findOrFail($request->id);
        $activitys=Activity::where('start_time','>=',date('Y-m-d H:i:s',time()))->get();
        return view('admin.user.pay',compact('user','activitys'));
    }
    //处理小记者缴费
    public function postPay(Request $request){
        $user=User::findOrFail($request->user_id);
        if($request->type=='会员'){
            DB::transaction(function () use ($request,$user) {
                $user->vip_type=1;
                $user->pay_type=0;
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
                    return ['error'=>1,'msg'=>'成为会员失败'];
                }

                //发送模板消息
                $openids=[];

                if(!empty($user->openid2)){
                    array_push($openids,$user->openid2);
                }
                if(!empty($user->openid1)){
                    array_push($openids,$user->openid1);
                }
                if(!empty($user->openid)){
                    array_push($openids,$user->openid);
                }

                $app = new Application(config('wechat'));
                $notice = $app->notice;

                foreach ($openids as $k=>$v){
                    $userId = $v;
                    $templateId = '-Cgy5aTMK5Dt6DYHBNwTvlNsnTu-XM-YCdbCkb8z_bw';
                    $url = config('app.url').'/user/index';
                    $data = array(
                        "first"  => '您好'.$user->name.'，您已经成为小记者啦！',
                        "keyword1"  => '报名成为小记者',
                        "keyword2"  => date('Y-m-d H:i',time()),
                        "keyword3"  => '欢迎来到小记者的行列',
                        "remark"   => '一起玩，就是这么嗨。',
                    );
                    $userService = $app->user;
                    $user=$userService->get($v);
                    if($user->subscribe==1){
                        @$notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
                    }

                }


                $data1['user_id']=$request->user_id;
                $data1['type']='会员';
                $data1['num']=$request->num;
                $data1['pay_type']=0;
                $res1=Pay::create($data1);
                if(!$res1){
                    return ['error'=>1,'msg'=>'成为会员缴费失败'];
                }

            });
        }else{
            DB::transaction(function () use ($request,$user) {
                $activity=Activity::find($request->type);
                $activity->num += 1;
                $activity->num1 += 1;
                //修改活动人数
                if(!$activity->save()){
                    return ['error'=>1,'msg'=>'参加活动失败'];
                }

                //增加记录
                $data=$request->only(['user_id']);
                $data['activity_id']=$request->type;
                $res=DB::table('user_activity')->insert($data);
                if(!$res){
                    return ['error'=>1,'msg'=>'参加活动失败'];
                }

                //发送模板消息
                $openids=[];

                if(!empty($user->openid2)){
                    array_push($openids,$user->openid2);
                }
                if(!empty($user->openid1)){
                    array_push($openids,$user->openid1);
                }
                if(!empty($user->openid)){
                    array_push($openids,$user->openid);
                }

                $app = new Application(config('wechat'));
                $notice = $app->notice;

                foreach ($openids as $k=>$v){
                    $userId = $v;
                    $templateId = '-Cgy5aTMK5Dt6DYHBNwTvlNsnTu-XM-YCdbCkb8z_bw';
                    $url = config('app.url').'/activity/show?id='.$activity->id;
                    $data = array(
                        "first"  => '您好，你报名的活动开始啦！',
                        "keyword1"  => $activity->name,
                        "keyword2"  => date('Y-m-d H:i',strtotime($activity->start_time)),
                        "keyword3"  => $activity->start_location,
                        "remark"   => '一起玩，就是这么嗨。',
                    );
                    $userService = $app->user;
                    $user=$userService->get($v);
                    if($user->subscribe==1){
                        @$notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
                    }

                }

                //增加支付记录 （收费活动加记录）
                $data1['user_id']=$request->user_id;
                $data1['type']=$activity->name;
                $data1['num']=$activity->num;
                $data1['pay_type']=0;
                $res1=Pay::create($data1);
                if(!$res1){
                    return ['error'=>1,'msg'=>'参加活动失败'];
                }

            });
        }

        return ['error'=>0,'msg'=>'缴费成功'];
    }

    //导入小记者文件记录
    public function getUserfile(){
        $userfiles=User_file::orderBy('id','desc')->paginate(10);
        return view('admin.user.userfile',compact('userfiles'));
    }

}

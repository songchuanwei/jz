<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\Classs;

class ClasssController extends Controller
{

    public function getIndex(Request $request)
    {
        $classs=Classs::orderBy('id','desc')->where(
            function($query) use ($request){
                if(!empty($request->title)){
                    $query->where('name', 'like', '%'.$request->title.'%')
                        ->orWhere('num', 'like', '%'.$request->title.'%');
                }
            }
        )->paginate(10);
        return view('admin.class.index',compact('classs'));
    }

    public function getAdd(){
        return view('admin.class.add');
    }
    public function postAdd(Request $request){
        $data=$request->only(['name','num']);
        $res=Classs::create($data);
        if($res){
            return ['error'=>0,'msg'=>'添加成功'];
        }else{
            return ['error'=>1,'msg'=>'添加失败'];
        }
    }

    public function getEdit(Request $request){
        $class=Classs::findOrFail($request->id);
        return view('admin.class.edit',compact('class'));
    }
    public function postEdit(Request $request){
        $class=Classs::find($request->id);
        $class->name=$request->name;
        $class->num=$request->num;
        $class->updated_at=date('Y-m-d H:i:s',time());
        if($class->save()){
            return ['error'=>0,'msg'=>'修改成功'];
        }else{
            return ['error'=>1,'msg'=>'修改失败'];
        }
    }

    public function getDel(Request $request){
        $class=Classs::findOrFail($request->id);
        if($class->delete()){
            return ['ennor'=>0,'msg'=>'删除成功'];
        }else{
            return ['ennor'=>1,'msg'=>'删除失败'];
        }
    }

}

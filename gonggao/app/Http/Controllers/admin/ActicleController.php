<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\Acticle;

class ActicleController extends Controller
{

    public function getIndex(Request $request)
    {
        $acticles=Acticle::orderBy('id','desc')->where(
            function($query) use ($request){
                if(!empty($request->title)){
                    $query->where('title', 'like', '%'.$request->title.'%')
                        ->orWhere('content', 'like', '%'.$request->title.'%');
                }
            }
        )->paginate(10);
        return view('admin.acticle.index',compact('acticles'));
    }

    public function getEdit(Request $request){
        $acticle=Acticle::findOrFail($request->id);
        return view('admin.acticle.edit',compact('acticle'));
    }
    public function postEdit(Request $request){
        $acticle=Acticle::find($request->id);
        $acticle->point=$request->point;
        $acticle->review=$request->review;
        $acticle->updated_at=date('Y-m-d H:i:s',time());
        if($acticle->save()){
            return ['error'=>0,'msg'=>'审阅成功'];
        }else{
            return ['error'=>1,'msg'=>'审阅失败'];
        }
    }

    public function getDel(Request $request){
        $acticle=Acticle::findOrFail($request->id);
        if($acticle->delete()){
            return ['ennor'=>0,'msg'=>'删除成功'];
        }else{
            return ['ennor'=>1,'msg'=>'删除失败'];
        }
    }

}

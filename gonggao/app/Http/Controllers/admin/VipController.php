<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class VipController extends Controller
{

    //vip价格列表
    public function getIndex(Request $request)
    {
        $vip=DB::table('vip')->first();
        return view('admin.vip.index',compact('vip'));
    }

    public function getEdit(Request $request){
        $vip=DB::table('vip')->first();
        return view('admin.vip.edit',compact('vip'));
    }
    public function postEdit(Request $request){
        $res=DB::table('vip')->where('id', $request->id)->update(['num' => $request->num]);
        if($res){
            return ['error'=>0,'msg'=>'修改成功'];
        }else{
            return ['error'=>1,'msg'=>'修改失败'];
        }
    }



}

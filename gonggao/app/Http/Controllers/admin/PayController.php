<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Activity;
use App\Models\Pay;
use DB;

class PayController extends Controller
{

    public function getIndex(Request $request)
    {
        $activitys=Activity::orderBy('id','desc')->get();

        $pays=Pay::orderBy('id','desc')->where(function($query) use ($request){
            if($request->activity){
                $query->where('type', '=',$request->activity);
            }
        })->paginate(10);

        //此活动总金额
        if($request->activity){
            $sum=Pay::where('type', '=',$request->activity)->sum('num');
        }else{
            $sum='请选择活动';
        }

        return view('admin.pay.index',compact('pays','activitys','request','sum'));
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table="users";
    protected $guarded = ['id'];

    //小记者参加的活动
    public function Activitys()
    {
        return $this->belongsToMany('App\Models\Activity', 'user_activity', 'user_id', 'activity_id');
    }
    //小记者是否参加此活动
    public function hasActivity($uid)
    {
        return $this->Activitys()->where('activity_id',$uid)->count();
    }

    //小记者参加的公开课
    public function Courses()
    {
        return $this->belongsToMany('App\Models\Course', 'user_course', 'user_id', 'course_id');
    }
    //小记者是否参加此公开课
    public function hasCourse($uid)
    {
        return $this->Courses()->where('course_id',$uid)->count();
    }

    //小记者的投稿
    public function Acticles()
    {
        return $this->hasMany('App\Models\Acticle', 'user_id', 'id');
    }

    //小记者的加分减分
    public function Points()
    {
        return $this->hasMany('App\Models\User_point', 'user_id', 'id');
    }

    //小记者是否参加活动的加分减分
    public function activityPoint($uid)
    {
        return $this->Points()->where('type','=',1)->where('point_id','=',$uid)->first();
    }
    //小记者是否参加核心素养课的加分减分
    public function coursePoint($uid)
    {
        return $this->Points()->where('type','=',2)->where('point_id','=',$uid)->first();
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table="activitys";
    protected $guarded = ['id'];

    //活动参加的小记者
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_activity', 'activity_id', 'user_id');
    }

    //活动的加分减分
    public function Points()
    {
        return $this->hasMany('App\Models\User_point', 'point_id', 'id')->where('type','=',1);
    }
}

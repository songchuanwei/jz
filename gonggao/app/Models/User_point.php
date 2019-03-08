<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_point extends Model
{
    protected $table="user_point";
    protected $guarded = ['id'];

    //扣分所属小记者
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    //扣分所属活动
    public function activity()
    {
        return $this->belongsTo('App\Models\Activity', 'point_id', 'id');
    }

    //扣分所属核心素养课
    public function course()
    {
        return $this->belongsTo('App\Models\Course', 'point_id', 'id');
    }

}

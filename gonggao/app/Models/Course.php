<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table="courses";
    protected $guarded = ['id'];

    //公开课参加的小记者
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_course', 'course_id', 'user_id');
    }
}
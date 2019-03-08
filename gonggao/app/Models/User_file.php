<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_file extends Model
{
    protected $table="user_file";
    protected $guarded = ['id'];

    //小记者的投稿
    public function admin()
    {
        return $this->belongsTo('App\Models\Admin', 'admin_id', 'id');
    }

}

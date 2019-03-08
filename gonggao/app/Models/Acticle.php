<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acticle extends Model
{
    protected $table="acticles";
    protected $guarded = ['id'];

    //小记者的投稿
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}

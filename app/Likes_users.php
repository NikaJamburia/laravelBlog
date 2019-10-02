<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes_users extends Model
{
    public $timestamps = false;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function post(){
        return $this->belongsTo('App\Post');
    }
}
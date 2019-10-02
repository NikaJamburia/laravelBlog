<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function likes(){
        return $this->hasMany('App\Likes_users');
    }

    public function comments(){
        return $this->hasMany('App\Comments');
    }

    public function categories(){
        return $this->belongsTo('App\Category');
    }
}

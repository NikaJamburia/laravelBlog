<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    public function posts(){
        return $this->hasMany('App\Post');
    }
}

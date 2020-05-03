<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
   // protected guarded = [];

    protected $table = 'comment';
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }




}

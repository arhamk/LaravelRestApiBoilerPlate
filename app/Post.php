<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{

   protected $fillable = ["user_id", "title", "bodt","slug"];

    public function scopeSlugLike($query, $slug)
    {
        return $query->where('slug', 'like', $slug . '%');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function comments(){
        return $this->hasMany(Comments::class);
    }

}

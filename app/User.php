<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Hash;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    public $rules =  [
//'name' => 'required|string',
//'username' => 'required|string',
//'email' => 'required|email|unique:users',
//'password' => 'required|string|min:6|max:10'
//];
    protected $fillable = [
        'name', 'email', 'password', 'username', 'number', 'max_token_count', 'client_id', 'enabled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Automatically creates hash for the user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


//    public function roles(){
//        return $this->belongsToMany(Role::class, 'user_roles', 'role_id', 'user_id');
//    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function phone(){
        return $this->hasOne(Phone::class);
    }

    public function posts(){
        return $this->hasMany(\App\Post::class);
    }

    public function comment(){
        return $this->hasMany(Comments::class);
    }









}

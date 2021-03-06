<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'birthday', 'gender', 'phone', 'service', 'post', 'email', 'password',
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
     * The models that should be exist on arrays.
     *
     * @var array
     */
    protected $with = ['categories'];

    public function userEmails()
    {
        return $this->hasMany('App\UserEmail');
    }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }
}

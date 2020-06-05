<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    public function userEmails()
    {
        return $this->hasMany('App\UserEmail');
    }

    public function replies()
    {
        return $this->hasMany('Email', 'email_id');
    }
}

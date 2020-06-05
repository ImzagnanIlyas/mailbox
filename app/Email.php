<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    public function UserEmails()
    {
        return $this->hasMany('App\UserEmail');
    }
}

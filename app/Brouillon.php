<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brouillon extends Model
{
    public function UserEmail()
    {
        return $this->belongsTo('App\UserEmail');
    }
}

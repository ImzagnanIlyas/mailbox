<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brouillon extends Model
{
    public function userEmail()
    {
        return $this->belongsTo('App\UserEmail');
    }
}

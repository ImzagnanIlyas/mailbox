<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corbeille extends Model
{
    public function userEmail()
    {
        return $this->belongsTo('App\UserEmail');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corbeille extends Model
{
    public function UserEmail()
    {
        return $this->belongsTo('App\UserEmail');
    }
}

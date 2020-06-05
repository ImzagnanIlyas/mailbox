<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmail extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function email()
    {
        return $this->belongsTo('App\Email');
    }

    public function brouillon()
    {
        return $this->hasOne('App\Brouillon');
    }

    public function corbeille()
    {
        return $this->hasOne('App\Corbeille');
    }
}

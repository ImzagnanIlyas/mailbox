<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserEmail extends Model
{
    protected $fillable = ['user_id', 'email_id', 'user_type', 'state'];
    protected $appends = ['sender', 'ccc'];

    /**
     * Laravel eloquent relationships
     */

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function email()
    {
        return $this->belongsTo('App\Email');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function brouillon()
    {
        return $this->hasOne('App\Brouillon');
    }

    public function corbeille()
    {
        return $this->hasOne('App\Corbeille');
    }

    /**
     * Custom attributes
     */

     public function getSenderAttribute(){
        $senderId = UserEmail::whereEmailId($this->email_id)->whereUserType('sender')->first()->user_id;
        return User::find($senderId);
     }
     public function getCccAttribute(){
        $ccc = UserEmail::All()->where('state', 'sent')->count();
        return $ccc;
     }


}

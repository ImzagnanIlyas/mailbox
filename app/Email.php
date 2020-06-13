<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $appends = ['send_at_short'];

    /**
     * Laravel eloquent relationships
     */

    public function userEmails()
    {
        return $this->hasMany('App\UserEmail');
    }

    public function replies()
    {
        return $this->hasMany('Email', 'email_id');
    }

    /**
     * Custom attributes
     */

    public function getSendAtShortAttribute(){
        $send_at = Carbon::parse($this->send)->locale('fr');
        $send_at_formatted = '';
        if ($send_at->isCurrentYear()) {
            if ($send_at->isCurrentDay()) {
                $send_at_formatted = $send_at->format('H:i');
            }else {
                $send_at_formatted = $send_at->format('d').' '.$send_at->shortMonthName;
            }
        }else {
            $send_at_formatted = $send_at->isoFormat('L');
        }

        return $send_at_formatted;
    }

    public function getSendAtFullAttribute(){

    }

}

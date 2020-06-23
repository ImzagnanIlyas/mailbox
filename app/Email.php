<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Email extends Model
{
    protected $fillable = ['user_id', 'send'];
    protected $appends = ['send_at_short', 'send_at_full', 'last_update_at', 'receivers_names'];

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

    public function getContentAttribute($value)
    {
        // return Crypt::decrypt($value);
        try {
            $decrypted = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            $decrypted = $value;
        }
        return $decrypted;
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = Crypt::encrypt($value);
    }

    /**
     * Custom attributes
     */

    public function getSendAtShortAttribute(){
        $send_at = Carbon::parse($this->send)->locale('fr');
        $send_at_formatted = '';
        if ($send_at->isCurrentYear()) {
            if ($send_at->isCurrentDay()) {
                $send_at_formatted = $send_at->isoFormat('HH:mm');
            }else {
                // $send_at_formatted = $send_at->format('d').' '.$send_at->shortMonthName;
                $send_at_formatted = $send_at->isoFormat('DD MMM');
            }
        }else {
            $send_at_formatted = $send_at->isoFormat('L');
        }

        return $send_at_formatted;
    }

    public function getSendAtFullAttribute(){
        $send_at = Carbon::parse($this->send)->locale('fr');
        $send_at_formatted = '';
        if ($send_at->isCurrentYear()) {
            if ($send_at->isCurrentDay()) {
                $send_at_formatted = $send_at->isoFormat('HH:mm').' ('.$send_at->diffForHumans().')';
            }else {
                $send_at_formatted = $send_at->isoFormat('dddd DD MMMM HH:mm').' ('.$send_at->diffForHumans().')';
            }
        }else {
            $send_at_formatted = $send_at->isoFormat('LLLL');
        }

        return $send_at_formatted;
    }

    public function getLastUpdateAtAttribute(){
        $updated_at = Carbon::parse($this->updated_at)->locale('fr');
        return $updated_at->diffForHumans();
    }

    public function getReceiversNamesAttribute(){
        $string = '';
        if ($this->receivers) {
            $ids = json_decode($this->receivers);
            foreach ($ids as $value) {
                $user = User::find($value);
                if ($value == Auth::user()->id) {
                    $string = 'moi, '.$string;
                }else{
                    $string .= substr($user->name, 0, strpos($user->name, " ")).', ';
                }
            }
            if(!$this->cc) $string = substr($string, 0, strrpos($string, ", "));
        }
        if ($this->cc) {
            $ids = json_decode($this->cc);
            foreach ($ids as $value) {
                $user = User::find($value);
                if ($value == Auth::user()->id) {
                    $string = 'moi, '.$string;
                }else{
                    $string .= substr($user->name, 0, strpos($user->name, " ")).', ';
                }
            }
            $string = substr($string, 0, strrpos($string, ", "));
        }
        return $string;
    }

}

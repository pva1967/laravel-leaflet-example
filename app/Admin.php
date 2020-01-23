<?php

namespace App;

use App\Notifications\MailResetPasswordToken;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordToken;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function is_Admin(){
        return $this != null;
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordToken($token, $this->name));
    }
}

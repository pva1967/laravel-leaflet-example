<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function is_Admin()
    {
        $role= DB::table('roles')
            ->where('user_id','=',$this->id)
            ->select('roles.role as role')
            ->first();
        if (null !== $role) {
            return $role->role == 'super_admin';
        }
        return false;
    }
    public function sendPasswordResetNotification($token)
    {
        $curr_user=Auth::user();
        if(null !== $curr_user) {
            $is_Admin = $curr_user->is_Admin();
        }
        else {
            $is_Admin = false;
        }

        $name = $this->name;
        $this->notify(new MailResetPasswordToken($token, $name, $is_Admin));
    }
    public function getNameLinkAttribute()
    {
        $title = __('app.show_detail_title', [
            'name' => $this->name, 'type' => __('outlet.outlet'),
        ]);
        $link = '<a href="'.route('user_edit.edit', $this).'"';
        $link .= ' title="'.$title.'">';
        $link .= $this->name;
        $link .= '</a>';

        return $link;
    }
}

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable // implements UserInterface, RemindableInterface
{
    use LaratrustUserTrait; // add this trait to your user model HasRole,
    use Notifiable;

    public static function rules($id = 0) {
        return [
            'email'             => 'required|max:50|min:10|email|unique:users,email' . ($id == 0 ? '' : ',' . $id),
            'fullname'          => 'required|max:50',
            'password'          => 'max:20|min:6' . ($id == 0 ? '|required' : ''),
            're_password'       => 'same:password',
            'roles'             => 'required',
            'phone' => 'max:12|regex:/[0]\d{9,11}$/',
            'info'  => 'max:255',
        ];
    }

    public function routeNotificationForSlack() {
        return env('SLACK_WEBHOOK_URL');
    }

    protected $hidden = ['password', 'remember_token'];

    // Don't forget to fill this array
    protected $fillable = [ 'email', 'fullname', 'password', 'remember_token', 'activated', 'last_login', 'phone', 'info', 'menu_is_collapse', 'permissions', 'password'];

    public function news()
    {
        return $this->hasMany('\App\News', 'created_by');
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getReminderEmail()
    {
        return $this->email;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function objNotifications()
    {
        return $this->morphToMany('\App\ObjNotification', 'obj_notifiable');
    }
}
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, LogsActivity;

    protected $fillable = [
        'username',
        'email',
        'password',
        'is_active',
        'email_verified_at',
        'password_changed_at',
        'two_factor_confirmed_at',
        'two_factor_secret',
        'two_factor_recovery_codes'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne('App\Models\UserProfile', 'user_id');
    }

    public function organization()
    {
        return $this->hasOne('App\Models\UserOrganization', 'user_id');
    }

    public function information()
    {
        return $this->hasOne('App\Models\UserInformation', 'user_id');
    }

    public function academics()
    {
        return $this->hasMany('App\Models\UserAcademic', 'user_id');
    }

    public function leaves()
    {
        return $this->hasMany('App\Models\LeaveCredit', 'user_id');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\SurveyAnswer', 'user_id');
    }

    public function credentials()
    {
        return $this->hasMany('App\Models\UserCredential', 'user_id')->orderBy('created_at','DESC');
    }

    public function contracts()
    {
        return $this->hasMany('App\Models\UserContract', 'user_id')->orderBy('created_at','DESC');
    }

    public function deductions()
    {
        return $this->hasMany('App\Models\UserDeduction', 'user_id')->orderBy('created_at','DESC');
    }

    public function credits()
    {
        return $this->hasMany('App\Models\UserCredit', 'user_id')->orderBy('created_at','DESC');
    }

    public function authentications()
    {
        return $this->haMany('App\Models\AuthenticationLog', 'user_id');
    }

    public function myroles()
    {
        return $this->hasMany('App\Models\UserRole', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\ListRole', 'user_roles', 'user_id', 'role_id');
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['username','email','is_active'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} the user information")
        ->useLogName('User')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}

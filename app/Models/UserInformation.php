<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserInformation extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['salary','accounts','contacts','backgrounds','barangay_code','user_id'];

    protected $casts = [
        'salary' => 'encrypted', 
        'accounts' => 'encrypted:json', 
        'contacts' => 'encrypted:json', 
        'backgrounds' => 'encrypted:json', 
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // public function setSalaryAttribute($value)
    // {
    //     $this->attributes['salary'] = trim(str_replace(',','',$value),'₱');
    // }

    // public function getSalaryAttribute($value)
    // {
    //     return '₱'.number_format($value,2,'.',',');
    // }


    // public function getSalaryAttribute($value)
    // {
    //     return number_format((float) $value, 2, '.', '');
    // }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['salary','accounts','contacts','backgrounds'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} the user information")
        ->useLogName('User Information')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}

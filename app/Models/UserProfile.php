<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserProfile extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = [];
    protected $fillable = ['firstname', 'lastname', 'middlename','suffix','sex','contact_no','mobile','user_id', 'avatar','signature','birthdate','marital_id','religion_id','blood_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function blood()
    {
        return $this->belongsTo('App\Models\ListData', 'blood_id', 'id');
    }

    public function marital()
    {
        return $this->belongsTo('App\Models\ListData', 'marital_id', 'id');
    }

    public function religion()
    {
        return $this->belongsTo('App\Models\ListData', 'religion_id', 'id');
    }

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = ucwords(strtolower($value));
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = ucwords(strtolower($value));
    }

    public function setMiddlenameAttribute($value)
    {
        $this->attributes['middlename'] = ucwords(strtolower($value));
    }

    protected static $recordEvents = ['updated'];
    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['firstname','lastname','middlename','suffix','sex','birthdate','contact_no','marital_id','religion_id','blood_id','signature','avatar'])
        ->setDescriptionForEvent(fn(string $eventName) => "$eventName the profile information")
        ->useLogName('User Profile')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}

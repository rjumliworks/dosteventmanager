<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSession extends Model
{
    protected $fillable = [
       'code',
       'title',
       'is_closed',
       'is_whole_day',
       'is_invitational',
       'is_exclusive',
       'is_limited',
       'has_registration',
       'venue_id',
       'event_id',
       'status_id'
    ];

    public function status()
    {
        return $this->belongsTo('App\Models\Dropdown', 'status_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'event_id', 'id');
    }

    public function venue()
    {
        return $this->belongsTo('App\Models\EventVenue', 'venue_id', 'id');
    }

    public function detail()
    {
        return $this->hasOne('App\Models\EventSessionDetail', 'session_id');
    } 

    public function schedules()
    {
        return $this->hasMany('App\Models\EventSessionSchedule', 'session_id');
    } 

    public function activities()
    {
        return $this->hasMany('App\Models\EventSessionActivity', 'session_id');
    } 

    public function managers()
    {
        return $this->hasMany('App\Models\EventSessionManager', 'session_id');
    } 

    public function participants()
    {
        return $this->hasMany('App\Models\EventSessionParticipant', 'session_id');
    } 

    public function attendees()
    {
        return $this->hasMany('App\Models\EventSessionParticipant', 'session_id')->where('status_id',8);
    } 
}

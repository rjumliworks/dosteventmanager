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
       'has_registration',
       'venue_id',
       'event_id'
    ];

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
}

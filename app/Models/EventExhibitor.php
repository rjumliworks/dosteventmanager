<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventExhibitor extends Model
{
    protected $fillable = [
       'code',
       'title',
       'institution',
       'description',
       'area',
       'is_active',
       'event_id'
    ];

    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'event_id', 'id');
    }

    public function contact()
    {
        return $this->hasOne('App\Models\EventExhibitorContact', 'exhibitor_id');
    } 

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}

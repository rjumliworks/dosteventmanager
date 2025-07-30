<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSessionParticipant extends Model
{
    protected $fillable = [
      'participant_id', 'session_id', 'status_id','method_id','attended_at'
    ];

    public function participant()
    {
        return $this->belongsTo('App\Models\Participant', 'participant_id', 'id');
    }

    public function getAttendedAtAttribute($value)
    {
        return date('F d, Y g:i a', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('F d, Y g:i a', strtotime($value));
    }
}

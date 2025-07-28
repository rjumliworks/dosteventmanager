<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSessionParticipant extends Model
{
    protected $fillable = [
      'participant_id', 'session_id', 'status_id','method_id','attended_at'
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventExhibitorReview extends Model
{
    protected $fillable = [
       'rate',
       'comment',
       'participant_id',
       'exhibitor_id'
    ];

    public function exhibitor()
    {
        return $this->belongsTo('App\Models\EventExhibitor', 'event_id', 'id');
    }

    public function participant()
    {
        return $this->belongsTo('App\Models\Participant', 'participant_id', 'id');
    }
}

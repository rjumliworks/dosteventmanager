<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsfEntry extends Model
{
    protected $fillable = [
        'comment',
        'attribute',
        'participant_id'
    ];

    public function feedbackable()
    {
        return $this->morphTo();
    }

    public function participant()
    {
        return $this->belongsTo('App\Models\Participant', 'participant_id', 'id');
    }

    public function rates()
    {
        return $this->hasMany('App\Models\CsfRating', 'csf_id');
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

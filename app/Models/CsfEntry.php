<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsfEntry extends Model
{
    protected $fillable = [
        'comment',
        'attribute',
        'user_id'
    ];

    public function feedbackable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
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

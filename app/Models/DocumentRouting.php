<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentRouting extends Model
{
    protected $fillable = ['document_id','route_to','is_action','created_at','updated_at'];

    public function comments()
    {
        return $this->morphMany('App\Models\DocumentComment', 'commentable');
    }
    
    public function document()
    {
        return $this->belongsTo('App\Models\Document', 'document_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'route_to', 'id');
    }

    public function getSeenedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCompletedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
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

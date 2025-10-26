<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicCsfEntry extends Model
{
     protected $fillable = [
        'rate',
        'comment',
        'attribute',
        'email',
        'name',
        'age',
        'sex'
    ];

    public function ratings()
    {
        return $this->hasMany('App\Models\PublicCsfRating', 'csf_id');
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsfRating extends Model
{
     protected $fillable = [
        'answer',
        'rating',
        'importance',
        'question_id',
        'csf_id'
    ];

    public function csf()
    {
        return $this->belongsTo('App\Models\CsfEntry', 'csf_id', 'id');
    }

    public function question()
    {
        return $this->belongsTo('App\Models\CsfQuestion', 'question_id', 'id');
    }
}

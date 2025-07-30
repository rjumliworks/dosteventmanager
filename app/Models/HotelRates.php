<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelRates extends Model
{
    protected $fillable = [
       'name',
       'detail',
       'rate',
       'hotel_id'
    ];

    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel', 'hotel_id', 'id');
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

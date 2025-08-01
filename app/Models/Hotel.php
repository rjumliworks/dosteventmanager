<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
       'code',
       'name',
       'link',
       'email',
       'contact_no',
       'is_active'
    ];

    public function location()
    {
        return $this->hasOne('App\Models\HotelLocation', 'hotel_id');
    } 

    public function rates()
    {
        return $this->hasMany('App\Models\HotelRates', 'hotel_id');
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

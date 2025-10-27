<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Testing extends Model
{
    protected $fillable = [
        'email',
        'password'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    public function getCreatedAttribute($value)
    {
        return date('F d, Y', strtotime($value));
    }
}

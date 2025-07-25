<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $hidden = ['name_hash', 'title_hash', 'establishment_hash'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Crypt::encryptString($value);
        $this->attributes['name_hash'] = hash('sha256', $value);
    }

    public function getNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = Crypt::encryptString($value);
        $this->attributes['title_hash'] = hash('sha256', $value);
    }

    public function getTitleAttribute($value)
    {
        return Crypt::decryptString($value);
    }

}

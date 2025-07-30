<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;

class Participant extends Authenticatable
{
    protected $guarded = [];

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    protected $fillable = [
        'email','contact_no','firstname','lastname','middlename','suffix','avatar', 'code', 'email_hash','contact_no_hash','firstname_hash','lastname_hash','middlename_hash'
    ];

    protected $hidden = [
        'email_hash','contact_no_hash','firstname_hash','lastname_hash','middlename_hash'
    ];

    public function detail()
    {
        return $this->hasOne('App\Models\ParticipantDetail', 'participant_id');
    }

    public function setFirstnameAttribute($value)
    {
        $value = ucfirst(strtolower($value));
        $this->attributes['firstname'] = Crypt::encryptString($value);
        $this->attributes['firstname_hash'] = hash('sha256', $value);
    }

    public function getFirstnameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function setMiddlenameAttribute($value)
    {
        $value = ucfirst(strtolower($value));
        $this->attributes['middlename'] = Crypt::encryptString($value);
        $this->attributes['middlename_hash'] = hash('sha256', $value);
    }

    public function getMiddlenameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function setLastnameAttribute($value)
    {
        $value = ucfirst(strtolower($value));
        $this->attributes['lastname'] = Crypt::encryptString($value);
        $this->attributes['lastname_hash'] = hash('sha256', $value);
    }

    public function getLastnameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function setEmailAttribute($value)
    {
        $email = strtolower($value);
        $this->attributes['email'] = Crypt::encryptString($email);
        $this->attributes['email_hash'] = hash('sha256', $email);
    }

    public function getEmailAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function setContactNoAttribute($value)
    {
        $this->attributes['contact_no'] = Crypt::encryptString($value);
        $this->attributes['contact_no_hash'] = hash('sha256', $value);
    }

    public function getContactNoAttribute($value)
    {
        return Crypt::decryptString($value);
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantDetail extends Model
{
    protected $fillable = [
        'designation','affiliation','birthdate','type_id','sex_id','avatar'
    ];

    public function sex()
    {
        return $this->belongsTo('App\Models\Dropdown', 'sex_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Dropdown', 'type_id', 'id');
    }

    public function setDesignationAttribute($value)
    {
        
        $this->attributes['designation'] = strtoupper($value);
    }

    public function setAffiliationAttribute($value)
    {
        $this->attributes['affiliation'] = strtoupper($value);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_slip',
        'subject',
        'keywords',
        'remarks',
        'actions',
        'is_incoming',
        'is_completed',
        'is_status',  
        'sender_id',
        'company_id',
        'type_id',
        'encoded_by',
        'routed_by',
        'received_at',
        'documented_at',
    ];

    protected $casts = [
        'keywords' => 'array'
    ];
    
    public function encoder()
    {
        return $this->belongsTo('App\Models\User', 'encoded_by', 'id');
    }

    public function router()
    {
        return $this->belongsTo('App\Models\User', 'routed_by', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'type_id', 'id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Models\ListKeyword', 'sender_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\ListKeyword', 'company_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany('App\Models\DocumentAttachment', 'document_id');
    } 

    public function routings()
    {
        return $this->hasMany('App\Models\DocumentRouting', 'document_id');
    } 

    public function getDocumentedAtAttribute($value)
    {
        return date('M d, Y', strtotime($value));
    }

    public function getReceivedAtAttribute($value)
    {
        return date('M d, Y', strtotime($value));
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

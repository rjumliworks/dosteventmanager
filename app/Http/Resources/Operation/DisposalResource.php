<?php

namespace App\Http\Resources\Operation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DisposalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'disposed_at' => ($this->disposed_at) ? $this->disposed_at : '-',
            'disposal' => ($this->disposal) ? $this->disposal->name : '-',
            'sample' => $this->sample,
            'status' => $this->status,
            'user' => ($this->user) ? $this->user->profile->firstname.' '.$this->user->profile->lastname : '-',
            'created_at' => $this->created_at
        ];
    }
}

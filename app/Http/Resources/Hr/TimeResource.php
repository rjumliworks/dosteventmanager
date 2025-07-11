<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'ip' => $this->ip,
            'pcname' => $this->pcname,
            'browser' => $this->browser,
            'date' => date('M d, Y g:i a', strtotime($this->date)),
            'time' =>  \Carbon\Carbon::parse($this->time)->format('h:i A'),
            'minutes' => $this->minutes,
            'is_updated' => $this->is_updated,
            'changes' => $this->changes
        ];
    }
}

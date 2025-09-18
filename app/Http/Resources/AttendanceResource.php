<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'attended_at' => $this->attended_at,
            'avatar' => asset('storage/'.$this->image),
            'participant' => $this->participant
        ];
    }
}

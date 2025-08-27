<?php

namespace App\Http\Resources;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParticipantListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        return [
            'code' => $code,
            'participant' => new ParticipantResource($this->participant),
            'status' => $this->status,
            'attended_at' => $this->attended_at,
            'created_at' => $this->created_at
        ];
    }
}

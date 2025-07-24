<?php

namespace App\Http\Resources;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $key = $hashids->encode($this->id);

        return [
            'id' => $this->id,
            'key' => $key,
            'code' => $this->code,
            'title' => $this->title,
            'schedules' => $this->schedules,
            'detail' => $this->detail,
            'venue' => $this->venue,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}

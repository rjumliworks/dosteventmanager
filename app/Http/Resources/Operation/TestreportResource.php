<?php

namespace App\Http\Resources\Operation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestreportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'sample_code' => $this->sample->code,
            'sample_id' => $this->sample->id,
            'tsr_code' => $this->sample->tsr->code,
            'analyses' => $this->sample->analyses,
            'user' => $this->user->profile->firstname.' '.$this->user->profile->lastname,
            'created_at' => $this->created_at
        ]; 
    }
}

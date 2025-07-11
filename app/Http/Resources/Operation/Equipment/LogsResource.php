<?php

namespace App\Http\Resources\Operation\Equipment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user->profile->firstname.' '.$this->user->profile->lastname,
            'date' => date('F d, Y', strtotime($this->date)),
            'is_calibrated' => $this->is_calibrated
        ];
    }
}

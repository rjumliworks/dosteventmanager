<?php

namespace App\Http\Resources\Hr;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PrintDtrResource extends JsonResource
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
            'date' => date('F d, Y', strtotime($this->date)),
            'user' => $this->user,
            'am_in_at' => new TimeResource(json_decode($this->am_in_at)),
            'am_out_at' => new TimeResource(json_decode($this->am_out_at)),
            'pm_in_at' => new TimeResource(json_decode($this->pm_in_at)),
            'pm_out_at' => new TimeResource(json_decode($this->pm_out_at)),
            'remarks' => json_decode($this->remarks),
            'created_at' => $this->created_at
        ];
    }
}

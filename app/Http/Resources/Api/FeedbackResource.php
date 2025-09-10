<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'rate' => $this->rate,
            'comment' => $this->comment,
            'name' => $this->participant->firstname.' '.$this->participant->lastname,
            'avatar' => $this->participant->detail->avatar,
            'created_at' => $this->created_at 
        ];
    }
}

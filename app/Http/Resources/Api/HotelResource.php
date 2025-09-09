<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'link' => $this->link,
            'email' => $this->email,
            'contact_no' => $this->contact_no,
            'avatar' => 'http://dosteventmanager.test/images/avatars/'.$this->avatar,
            'location' => $this->location,
            'rates' => $this->rates
        ];
    }
}

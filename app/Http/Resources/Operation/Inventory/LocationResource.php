<?php

namespace App\Http\Resources\Operation\Inventory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->code,
            'code' => $this->code,
            'name' => $this->name,
            'region' => $this->region
        ];
    }
}

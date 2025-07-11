<?php

namespace App\Http\Resources\Operation\Inventory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'contact_no' => $this->contact_no,
            'address' => $this->address,
            'is_active' => $this->is_active,
            'barangay' => new LocationResource($this->barangay),
            'municipality' => new LocationResource($this->municipality),
            'province' => new LocationResource($this->municipality->province),
            'region' => new LocationResource($this->municipality->province->region)
        ];
    }
}

<?php

namespace App\Http\Resources\Operation\Verification;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Operation\CustomerResource;

class IndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        return [
            'id' => $this->id,
            'qr' => $code,
            'code' => $this->code,
            'laboratory' => $this->laboratory,
            'laboratory_type' => $this->laboratory_type,
            'status' => $this->status,
            'customer' => new CustomerResource($this->customer),
            'conforme' => $this->conforme->name, 
            'conforme_no' => $this->conforme->contact_no, 
            'received' => $this->received->profile->firstname.' '.$this->received->profile->lastname,
            'payment' => $this->payment,
            'due_at' => $this->due_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}

<?php

namespace App\Http\Resources\Operation;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        return [
            'id' => $this->id,
            'qr' => $code,
            'code' => $this->code,
            'mode' => $this->mode,
            'total' => $this->total,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'discounted' => $this->discounted,
            'laboratory' => $this->laboratory,
            'terms' => json_decode($this->terms,true),
            'type' => $this->type,
            'status' => $this->status,
            'customer' => new CustomerResource($this->customer),
            'conforme' => $this->conforme->name, 
            'conforme_no' => $this->conforme->contact_no,
            'conforme_id' => $this->conforme->id, 
            'received' => $this->createdby->profile->firstname.' '.$this->createdby->profile->lastname,
            'samples' => SampleResource::collection($this->samples),
            'service' => $this->service,
            'due_at' => $this->due_at,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}

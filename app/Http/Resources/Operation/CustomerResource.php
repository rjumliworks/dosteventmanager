<?php

namespace App\Http\Resources\Operation;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        return [
            'id' => $this->id,
            'code' => $code,
            'email' => $this->contact->email,
            'contact_no' => $this->contact->contact_no,
            'name' => ($this->customer_name->has_branches) ? ($this->is_main) ? $this->customer_name->name :  $this->customer_name->name.' - '.$this->name : $this->customer_name->name,
            'address' => new AddressResource($this->address),
            'industry' => ($this->industry) ? $this->industry->name : '',
            'wallet' => $this->wallet,
            'conformes' => ConformeResource::collection($this->conformes),
        ];
    }
}

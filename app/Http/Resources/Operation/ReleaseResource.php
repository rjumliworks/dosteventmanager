<?php

namespace App\Http\Resources\Operation;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReleaseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->tsr->id);
        $name = ($this->tsr->customer->name == 'Main') ? '' : ' - '.$this->tsr->customer->name;
        return [
            'id' => $this->id,
            'qr' => $code,
            'code' => $this->tsr->code,
            'due_at' => $this->tsr->due_at,
            'status' => $this->status,
            'released_at' => ($this->released_at) ? $this->released_at : '-',
            'user' => ($this->user) ? $this->user->profile->firstname.' '.$this->user->profile->lastname : '-',
            'customer' => $this->tsr->customer->customer_name->name.$name,
            'contact_no' => $this->tsr->customer->contact->contact_no,
            'email' => $this->tsr->customer->contact->email,
            'conforme' => $this->tsr->conforme,
            'created_at' => $this->created_at
        ];
    }
}

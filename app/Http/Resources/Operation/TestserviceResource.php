<?php

namespace App\Http\Resources\Operation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestserviceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'is_checked' => false,
            'is_fixed' => $this->is_fixed,
            'value' => $this->id,
            'name' => $this->testname->name.' - '.$this->method->method->name.' ('.$this->method->reference->name.')',
            'sampletype' => $this->sampletype->name,
            'testname' => $this->testname->name,
            'method' => $this->method->method->name,
            'method_short' => $this->method->method->short,
            'reference' => $this->method->reference->name,
            'fee' => $this->method->fee,
            'fee_num' => trim(str_replace(',','',$this->method->fee),'₱'),
        ];
    }
}

<?php

namespace App\Http\Resources\Operation\Quotation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalysisResource extends JsonResource
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
            'fee' => $this->fee,
            'status' => $this->status,
            'code' => $this->sample->code,
            'sample' => $this->sample->name,
            'testname' => $this->testservice->testname->name,
            'method' => $this->testservice->method->method->name,
            'reference' => $this->testservice->method->reference->name,
            'additional' => $this->testservice->fees,
            'addfee' => $this->addfee,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at
        ];
    }
}

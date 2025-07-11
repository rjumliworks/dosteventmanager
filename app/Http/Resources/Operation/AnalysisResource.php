<?php

namespace App\Http\Resources\Operation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnalysisResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fee' => $this->fee,
            'selected' => false,
            'status' => $this->status,
            'code' => $this->sample->code,
            'sample' => $this->sample->name,
            'testname' => $this->testservice->testname->name,
            'method' => $this->testservice->method->method->name,
            'reference' => $this->testservice->method->reference->name,
            'analyst' => ($this->analyst) ? $this->analyst->profile->firstname.' '.$this->analyst->profile->lastname : '-',
            'analyst_id' => ($this->analyst) ? $this->analyst->id : null,
            'additional' => $this->testservice->fees,
            'addfee' => $this->addfee,
            'is_fixed' => $this->is_fixed,
            'start_at' => ($this->start_at != 'Jan 01, 1970') ? $this->start_at : '-',
            'end_at' => ($this->end_at != 'Jan 01, 1970') ? $this->end_at : '-'
        ];
    }
}

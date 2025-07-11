<?php

namespace App\Http\Resources\Operation;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SampleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        return [
            'id' => $this->id,
            'qr' => $code,
            'code' => $this->code,
            'name' => $this->name,
            'customer_description' => $this->customer_description,
            'description' => $this->description,
            'is_completed' => $this->is_completed,
            'is_disposed' => $this->is_disposed,
            'disposal' => new DisposalResource($this->disposal),
            'analyses' => AnalysisResource::collection($this->analyses),
            'report' => $this->report,
            'selected' => false,
            'tsr_id' => ($this->tsr) ? $this->tsr->id : null,
            'due_at' => ($this->tsr) ? $this->tsr->due_at : null,
            'created_at' => ($this->tsr) ? $this->created_at : null
        ];
    }
}

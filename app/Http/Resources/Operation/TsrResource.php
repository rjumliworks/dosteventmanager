<?php

namespace App\Http\Resources\Operation;

use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TsrResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $hashids = new Hashids('krad',10);
        $code = $hashids->encode($this->id);

        $total = 0; $completed = 0; $ongoing = 0;
        if(count($this->samples) > 0){
            foreach ($this->samples as $result) {
                $total = $total + $result->analyses_count;
                $completed = $completed + $result->completed_analyses_count;
                $ongoing = $ongoing + $result->ongoing_analyses_count;
            }

            $completedPercentage = ($completed != 0) ? ($completed / $total) * 100 : 0;
            $ongoingPercentage = ($ongoing != 0) ? ($ongoing / $total) * 100 : 0;
            $ongoingPercentage = ($ongoingPercentage != 0) ? $ongoingPercentage/2 : 0;

            $analyses = [$completedPercentage+$ongoingPercentage];
        }else{
            $analyses = [0];
        }

        return [
            'id' => $this->id,
            'qr' => $code,
            'code' => $this->code,
            'laboratory_type' => $this->laboratory_type,
            'status' => $this->status,
            'customer' => new CustomerResource($this->customer),
            'payment' => $this->payment,
            'due_at' => $this->due_at,
            'purpose' => $this->purpose,
            'analyses' => $analyses,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}

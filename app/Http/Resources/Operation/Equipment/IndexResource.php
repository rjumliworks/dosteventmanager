<?php

namespace App\Http\Resources\Operation\Equipment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'manufacturer' => $this->info->manufacturer,
            'model' => $this->info->model,
            'serial_no' => $this->info->serial_no,
            'price' => $this->info->price,
            'supplier_id' => $this->info->supplier_id,
            'acquired_at' => ($this->info->acquired_at) ? $this->info->acquired_at : '-',
            'calibration_due' => ($this->calibration_due) ? $this->calibration_due : '-',
            'maintenance_due' => ($this->maintenance_due) ? $this->maintenance_due : '-',
            'logs' => LogsResource::collection($this->logs),
            'last_calibration' => ($this->last_calibration) ? $this->last_calibration : '-',
            'last_maintenance' => ($this->last_maintenance) ? $this->last_maintenance : '-',
            'calibration_program' => $this->calibration_program,
            'maintenance_plan' => $this->maintenance_plan,
            'calibration_testpoints' => $this->calibration_testpoints,
            'others' => $this->info->others,
            'laboratory_type' => $this->laboratory_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}

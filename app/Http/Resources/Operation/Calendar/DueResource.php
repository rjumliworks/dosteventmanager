<?php

namespace App\Http\Resources\Operation\Calendar;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DueResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // dd($this->laboratory_type->color);
        switch($this->laboratory_type){
            case 'red':
                $color = 'bg-danger text-white';
            break;
            case 'green':
                $color = 'bg-success text-white';
            break;
            case 'blue':
                $color = 'bg-info text-white';
            break;
            default:
                $color = 'bg-info text-white';
        }
        return [
            'id' => $this->id,
            'title' => $this->code,
            'start' => date("Y-m-d",strtotime($this->due_at)).' 08:00:00',
            'end' => date("Y-m-d",strtotime($this->due_at)).' 17:00:00',
            'className' => $color,
            'full_title' => $this->code,
            'full_name' => ($this->customer->customer_name->has_branches) ? ($this->is_main) ? $this->customer->customer_name->name :  $this->customer->customer_name->name.' - '.$this->customer->name : $this->customer->customer_name->name,
            'start_date' => date("M d, Y",strtotime($this->due_at)),
            'end_date' => date("M d, Y",strtotime($this->due_at)),
            's_date' => date("Y-m-d",strtotime($this->due_at)),
            'e_date' => date("Y-m-d",strtotime($this->due_at)),
            'ss_date' => date("M d, Y",strtotime($this->due_at)),
            'ee_date' => date("M d, Y",strtotime($this->due_at)),
            'datee' => $this->due_at,
            'venue' => 'venue',
            'description' => 'description',
            'is_allday' => 'allday',
            'event' => 'TSR',
        ];
    }
}

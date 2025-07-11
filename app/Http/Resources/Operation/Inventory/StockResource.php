<?php

namespace App\Http\Resources\Operation\Inventory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'old_code' => $this->old_code,
            'name' => $this->item->name,
            'brand' => ($this->brand) ? $this->brand : "Not specified",
            'quantity' => $this->quantity,
            'onhand' => $this->onhand,
            'number' => $this->number,
            'unit' => $this->unit,
            'unit_id' => $this->unit_id,
            'type' => $this->unittype->name,
            'price' => $this->price,
            'supplier' => ($this->suppliers) ? $this->suppliers->name : $this->supplier, 
            'supplier_id' => $this->supplier_id,
            'bought_at' => $this->bought_at,
            'expired_at' => $this->expired_at,
            'withdrawals' => $this->withdrawals
        ];
    }
}

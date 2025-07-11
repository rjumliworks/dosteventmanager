<?php

namespace App\Http\Resources\Operation\Inventory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'old_code' => $this->old_code,
            'reorder' => $this->reorder,
            'unit' => $this->unittype->name,
            'unit_id' => $this->unit_id,
            'is_active' => $this->is_active,
            'onhand' => ($this->onhand ) ? $this->onhand : 0,
            'stock' => ($this->stock ) ?  $this->formatNumber($this->stock) : 0,
            'category' => ($this->category) ? $this->category->name : 'Not Specified',
            'category_id' => $this->category_id,
            'stocks' => StockResource::collection($this->whenLoaded('stocks'))
        ];
    }

    protected function formatNumber($number)
    {
        return strpos($number, '.') !== false ? rtrim(rtrim(number_format($number, 3, '.', ''), '0'), '.') : $number;
    }
}

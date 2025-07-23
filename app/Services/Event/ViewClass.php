<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Http\Resources\EventResource;

class ViewClass
{
    public function lists($request){
        $data = EventResource::collection(
            Event::when($request->keyword, function ($query,$keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate($request->count)
        );
        return $data;
    }
}

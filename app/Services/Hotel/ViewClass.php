<?php

namespace App\Services\Hotel;

use App\Models\Hotel;
use App\Http\Resources\DefaultResource;

class ViewClass
{
     public function lists($request){
        $data = DefaultResource::collection(
            Hotel::with('rates')
            ->with('location.region:code,name,region','location.province:code,name','location.municipality:code,name','location.barangay:code,name')
            ->when($request->keyword, function ($query,$keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate($request->count)
        );
        return $data;
    }
}

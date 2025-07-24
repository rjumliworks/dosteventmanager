<?php

namespace App\Services\Event;

use Hashids\Hashids;
use App\Models\Event;
use App\Http\Resources\EventResource;

class ViewClass
{
    public function lists($request){
        $data = EventResource::collection(
            Event::with('venues')
            ->with('sessions.venue','sessions.detail','sessions.schedules')
            ->with('detail.region:code,name,region','detail.province:code,name','detail.municipality:code,name','detail.barangay:code,name')
            ->when($request->keyword, function ($query,$keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('created_at', 'DESC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function view($id){
        $hashids = new Hashids('krad',10);
        $key = $hashids->decode($id);

        $data = new EventResource(
            Event::with('venues')->with('sessions.venue','sessions.detail','sessions.schedules')
            ->with('detail.region:code,name,region','detail.province:code,name','detail.municipality:code,name','detail.barangay:code,name')
            ->where('id',$key)->first()
        );
        return $data;
    }
}

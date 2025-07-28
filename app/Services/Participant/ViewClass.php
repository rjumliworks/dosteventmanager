<?php

namespace App\Services\Participant;

use App\Models\Participant;
use App\Http\Resources\ParticipantResource;

class ViewClass
{
    public function lists($request){
        $data = ParticipantResource::collection(
            Participant::query()
            ->with('detail.type','detail.sex')
            ->when($request->keyword, function ($query, $keyword) {
                
            })
            ->paginate($request->count)
        );
        return $data;
    }
}

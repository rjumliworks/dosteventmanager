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
            ->when($request->type, function ($query, $type) {
                $query->whereHas('detail', function ($q) use ($type) {
                    $q->where('type_id', $type);
                });
            })
             ->when($request->affiliation, function ($query, $affiliation) {
                $query->whereHas('detail', function ($q) use ($affiliation) {
                    $q->where('affiliation', $affiliation);
                });
            })
            ->paginate($request->count)
        );
        return $data;
    }
}

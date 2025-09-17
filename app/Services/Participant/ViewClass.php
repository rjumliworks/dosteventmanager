<?php

namespace App\Services\Participant;

use App\Models\Participant;
use App\Http\Resources\ParticipantResource;
use Illuminate\Support\Facades\Crypt;

class ViewClass
{
    public function lists($request){
        $data = ParticipantResource::collection(
            Participant::query()
            ->with('detail.type','detail.sex')
            ->when($request->type,  function ($query , $type) {
                $query->whereHas('detail.type', function ($q) use ($type) {
                    $q->where('id', 'LIKE', "%{$type}%");
                });
            })
            ->when($request->keyword,  function ($query, $keyword) {
                $query->whereHas('detail.type', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%")
                      ->orWhere('affiliation', 'LIKE', "%{$keyword}%")
                      ->orWhere('birthdate', 'LIKE', "%{$keyword}%");
                })
                ->orWhere('firstname', 'LIKE', "%{$keyword}%")
                ->orWhere('lastname', 'LIKE', "%{$keyword}%");
            })
            ->paginate($request->count)
        );
        return $data;
    }
}

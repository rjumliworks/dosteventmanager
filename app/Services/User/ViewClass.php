<?php

namespace App\Services\User;

use App\Models\User;
use App\Http\Resources\UserResource;

class ViewClass
{
    public function lists($request){
        $data = UserResource::collection(
            User::query()
            ->with('profile')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('profile',function ($query) use ($keyword) {
                    $query->whereRaw('concat(firstname, " ", lastname) LIKE ?', ['%' . $keyword . '%'])
                    ->orWhereRaw('concat(lastname, " ", firstname) LIKE ?', ['%' . $keyword . '%']);
                })->orWhere(function ($query) use ($keyword) {
                    $query->where('username', 'LIKE', "%{$keyword}%")->whereNotIn('role',['Administrator']);
                });
            })
            ->paginate($request->count)
        );
        return $data;
    }
}

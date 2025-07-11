<?php

namespace App\Services\Hr\Dtr;

use App\Models\Dtr;
use App\Http\Resources\Hr\DtrResource;

class ViewClass
{
    public function lists($request){
        $data = DtrResource::collection(
            Dtr::with('user:id,email,username','user.profile:user_id,firstname,middlename,lastname')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('user',function ($query) use ($keyword) {
                    $query->whereHas('profile',function ($query) use ($keyword) {
                        $query->when($keyword, function ($query, $keyword) {
                            $query->whereRaw('concat(firstname, " ", lastname) LIKE ?', ['%' . $keyword . '%'])
                            ->orWhereRaw('concat(lastname, " ", firstname) LIKE ?', ['%' . $keyword . '%']);
                        });
                    });
                });
            })
            ->when($request->date, function ($query, $date) {
                $query ->where('date',$date);
            })
            ->orderBy('created_At', 'DESC')
            ->paginate($request->count)
        );
        return $data;
    }
}

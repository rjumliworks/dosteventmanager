<?php

namespace App\Services\User;

use App\Models\User;
use App\Http\Resources\UserResource;

class SaveClass
{
     public function store($request){
        $data = User::create(array_merge($request->all(), ['password' => bcrypt('dost6!@#$%'),'avatar' =>'avatar.jpg']));
        $data->profile()->create($request->all());
 
        return [
            'data' => $data,
            'message' => 'User creation was successful!', 
            'info' => "You've successfully created an account for the user."
        ];
    }

    public function update($request){
        $data = User::with('profile')->where('id',$request->id)->first();
        $data->update($request->all());

        return [
            'data' => new UserResource($data),
            'message' => 'User update was successful!', 
            'info' => "You've successfully updated the selected user."
        ];
    }
}

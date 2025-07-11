<?php

namespace App\Services\Executive;

use App\Models\User;
use App\Models\ListRole;
use App\Models\ListMenu;
use App\Http\Resources\UserResource;
use App\Http\Resources\DefaultResource;

class UpdateClass
{
    public function user($request){
        $data = User::with('profile')->where('id',$request->id)->first();
        $data->update($request->all());

        return [
            'data' => new UserResource($data),
            'message' => 'User update was successful!', 
            'info' => "You've successfully updated the selected user."
        ];
    }

    public function role($request){
        $data = ListRole::where('id',$request->id)->first();
        $data->update($request->all());

        return [
            'data' => new DefaultResource($data),
            'message' => 'Role update was successful!', 
            'info' => "You've successfully updated the selected role."
        ];
    }

    public function menu($request){
        $data = ListMenu::where('id',$request->id)->first();
        $data->update($request->all());

        return [
            'data' => new DefaultResource($data),
            'message' => 'Menu update was successful!', 
            'info' => "You've successfully updated the selected menu."
        ];
    }
}

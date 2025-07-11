<?php

namespace App\Services\Hr\Employee;

use App\Models\UserInformation;

class UpdateClass
{
    public function background($request){
        $data = UserInformation::where('user_id',$request->id)->first();
        $data->backgrounds = json_encode($request->background);
        $data->save();

        return [
            'data' => $data,
            'message' => 'Information Updated successfully.', 
            'info' => 'Your information was updated.',
        ];
    }

    public function account($request){
        $data = UserInformation::where('user_id',$request->id)->first();
        $data->accounts = json_encode($request->accounts);
        $data->save();

        return [
            'data' => $data,
            'message' => 'Accounts Updated successfully.', 
            'info' => 'Your information was updated.',
        ];
    }

    public function salary($request){
        $data = UserInformation::where('user_id',$request->id)->first();
        $data->salary = $request->salary;
        $data->save();

        return [
            'data' =>  $data->only('salary'),
            'message' => 'Salary Updated successfully.', 
            'info' => 'Your information was updated.',
        ];
    }
}

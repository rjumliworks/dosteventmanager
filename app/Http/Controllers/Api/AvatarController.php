<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function store(Request $request){

        try {
            $request->validate([
                'image' => 'required|image64:jpeg,jpg,png' // Assuming maximum file size is 2MB
            ]);

            
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

           

           
            if($request->image){
                $dd = $request->image;
                $img = explode(',', $dd);
                $ini =substr($img[0], 11);
                $type = explode(';', $ini);
                if($type[0] == 'png'){
                    $image = str_replace('data:image/png;base64,', '', $dd);
                }else{
                    $image = str_replace('data:image/jpeg;base64,', '', $dd);
                }
                $image = str_replace(' ', '+', $image);
                $imageName =  date('Y').'-'.date('mhis').'.'.$type[0];
                
                if(\File::put(public_path('images/avatars'). '/' . $imageName, base64_decode($image))){
                    $data = Participant::with('detail')->where('id',$request->id)->first();
                    if ($data->detail->avatar) {
                        Storage::disk('public')->delete($data->detail->avatar);
                    }

                    $data->detail->avatar = $imageName;
                    $data->detail->save();

                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'data' => true
            ], 200);

        }catch(\Throwable $th){

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

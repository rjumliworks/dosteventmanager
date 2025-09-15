<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048'
            // 'image' => 'required|image64:jpeg,jpg,png|max:2048' // Assuming maximum file size is 2MB
        ]);

        $data = Participant::with('detail')->where('id',$request->id)->first();
        if ($data->detail->avatar) {
            Storage::disk('public')->delete($data->detail->avatar);
        }

        $imagePath = $request->file('image')->store('mobile-pictures', 'public');
        $data->detail->avatar = $imagePath;
        $data->detail->save();

         return response()->json([
            'status' => true,
            'message' => 'Question submitted successfully',
            'data' => true
        ], 200);
    }
}

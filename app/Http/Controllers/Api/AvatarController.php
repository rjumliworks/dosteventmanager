<?php

namespace App\Http\Controllers\Api;

use Hashids\Hashids;
use App\Models\Participant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function avatar(Request $request){

        try {
            $request->validate([
                'image' => 'required|image|max:2048', // Assuming maximum file size is 2MB
            ]);
           
                $participant = Participant::with('detail')->findOrFail($request->id);

                // Delete old avatar if exists
                if ($participant->detail->avatar) {
                    Storage::disk('public')->delete('images/avatars/' . $participant->detail->avatar);
                }

                $hashids = new Hashids('krad',10);
                $key = $hashids->encode($request->id);
                // Store new image
                $extension = $request->file('image')->getClientOriginalExtension();
                $filename  = $key . '.' . $extension;
                $path = $request->file('image')->storeAs('images/avatars', $filename, 'public');

                $participant->detail->avatar = $path;
                $participant->detail->save();

                return response()->json([
                    'status'  => true,
                    'message' => 'Profile updated successfully',
                    'data'    => $filename
                ]);

        }catch(\Throwable $th){

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function signature(Request $request){

        try {
            $request->validate([
                'signature' => 'required|image|max:2048', // Assuming maximum file size is 2MB
            ]);
           
                $participant = Participant::with('detail')->findOrFail($request->id);

                // Delete old avatar if exists
                if ($participant->detail->avatar) {
                    Storage::disk('public')->delete('signatures/' . $participant->detail->avatar);
                }

                $hashids = new Hashids('krad',10);
                $key = $hashids->encode($request->id);
                // Store new image
                $extension = $request->file('image')->getClientOriginalExtension();
                $filename  = $key . '.' . $extension;
                $path = $request->file('image')->storeAs('images/signatures', $filename, 'public');

                $participant->detail->signature = $path;
                $participant->detail->save();

                return response()->json([
                    'status'  => true,
                    'message' => 'Profile updated successfully',
                    'data'    => $filename
                ]);

        }catch(\Throwable $th){

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}

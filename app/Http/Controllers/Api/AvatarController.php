<?php

namespace App\Http\Controllers\Api;

use Hashids\Hashids;
use App\Models\Participant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function store(Request $request){

        try {
            $request->validate([
                'image' => 'required|image|max:2048', // Assuming maximum file size is 2MB
            ]);
           
                $participant = Participant::with('detail')->findOrFail($request->id);

                // Delete old avatar if exists
                if ($participant->detail->avatar) {
                    Storage::disk('public')->delete('images/avatars/' . $participant->detail->avatar);
                }

                // Store new image
                $path = $request->file('image')->store('images/avatars', 'public');

                // Only store filename if you want, or the full path
                $filename = basename($path);

                $participant->detail->avatar = $filename;
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

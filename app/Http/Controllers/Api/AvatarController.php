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
                'image' => 'required|image64:jpeg,jpg,png' // Assuming maximum file size is 2MB
            ]);
           
            if ($request->image) {
                $dataUri = $request->image;
                [$meta, $content] = explode(',', $dataUri);
                if (str_contains($meta, 'png')) {
                    $extension = 'png';
                } else {
                    $extension = 'jpg'; // default to jpg if jpeg
                }

            // Decode the base64 string
            $image = base64_decode($content);

            $hashids = new Hashids('krad',10);
            $key = $hashids->encode($request->id);

            // Create a unique file name
            $imageName = $key . '.' . $extension;
            $path      = 'images/avatars/' . $imageName; // relative to storage/app/public

            // Save using Laravel's storage (storage/app/public/images/avatars)
            Storage::disk('public')->put($path, $image);

            // Update DB and delete old file
            $participant = Participant::with('detail')->findOrFail($request->id);

            if (!empty($participant->detail->avatar)) {
                // delete the old avatar if it exists
                Storage::disk('public')->delete($participant->detail->avatar);
            }

            // Save new path (recommended to store full relative path)
            $participant->detail->avatar = $path;
            $participant->detail->save();
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

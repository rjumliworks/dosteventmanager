<?php

namespace App\Http\Controllers\Api;

use Hashids\Hashids;
use App\Models\Participant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    public function completed(Request $request){
        $data = Participant::where('id',$request->id)->first();
        $data->is_completed = 1;
        $data->save();
        $data->refresh();

        return response()->json([
            'status'  => true,
            'message' => 'Completed updated successfully',
            'data'    => $data->is_completed
        ]);
    }

    public function avatar(Request $request){

        try {
            $request->validate([
                'image' => 'required|image|max:2048', // Assuming maximum file size is 2MB
            ]);
           
                $participant = Participant::with('detail')->findOrFail($request->id);

                // Delete old avatar if exists
                if ($participant->detail->image) {
                    Storage::disk('public')->delete($participant->detail->signature);
                }

                $path = $this->image($request);

                $participant->detail->image = $path;
                $participant->detail->save();

                return response()->json([
                    'status'  => true,
                    'message' => 'Profile updated successfully',
                    'data'    => asset('storage/'.$participant->detail->image)
                ]);

        }catch(\Throwable $th){

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function image($request)
    {
        $image = $request->input('image'); // base64 string

        // Validate format
        if (!preg_match('/^data:image\/(\w+);base64,/', $image, $matches)) {
            return response()->json(['error' => 'Invalid image format.'], 422);
        }

        $type = strtolower($matches[1]); // png, jpg, jpeg, gif
        if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
            return response()->json(['error' => 'Invalid image type.'], 422);
        }

        // Remove header and decode
        $image = substr($image, strpos($image, ',') + 1);
        $image = str_replace(' ', '+', $image);
        $imageData = base64_decode($image);

        if ($imageData === false) {
            return response()->json(['error' => 'Base64 decode failed.'], 422);
        }

        // Save to storage/app/public/images/attendance
        $filename = Str::random(10) . '.' . $type;
        $path = 'images/attendance/' . $filename;
        Storage::disk('public')->put($path, $imageData);

        return $path;
    }

    public function signature(Request $request){

        try {
            $request->validate([
                'signature' => 'required|image|max:2048', // Assuming maximum file size is 2MB
            ]);
           
                $participant = Participant::with('detail')->findOrFail($request->id);

                // Delete old avatar if exists
                if ($participant->detail->signature) {
                    Storage::disk('public')->delete('signatures/' . $participant->detail->signature);
                }

                $hashids = new Hashids('krad',10);
                $key = $hashids->encode($request->id);
                // Store new image
                $extension = $request->file('signature')->getClientOriginalExtension();
                $filename  = $key . '.' . $extension;
                $path = $request->file('signature')->storeAs('images/signatures', $filename, 'public');

                $participant->detail->signature = $path;
                $participant->detail->save();

                return response()->json([
                    'status'  => true,
                    'message' => 'Profile updated successfully',
                    'data'    => $this->convertToBase64($participant->detail->signature)
                ]);

        }catch(\Throwable $th){

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function convertToBase64($path)
    {
        // If you store public files like: storage/app/public/signatures/filename.png
        // and you saved the DB value like: signatures/filename.png
        if (Storage::disk('public')->exists($path)) {
            $file = Storage::disk('public')->get($path);
            $mime = Storage::disk('public')->mimeType($path);
            return 'data:' . $mime . ';base64,' . base64_encode($file);
        }

        // If you stored a full URL instead of a storage path:
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            try {
                $file = file_get_contents($path);
                $mime = @mime_content_type($path) ?: 'image/png';
                return 'data:' . $mime . ';base64,' . base64_encode($file);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }
}

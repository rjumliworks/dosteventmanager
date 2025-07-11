<?php

namespace App\Services\Executive;

use Storage;
use Carbon\Carbon;
use App\Models\User;
use App\Models\ListRole;
use App\Models\ListMenu;
use App\Models\AuthenticationLog;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\AuthenticationResource;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ViewClass
{
    public function users($request){
        $data = UserResource::collection(
            User::query()
            ->with('profile','myrole.type','myrole.laboratory')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('profile',function ($query) use ($keyword) {
                    $query->where(\DB::raw('concat(firstname," ",lastname)'), 'LIKE', "%{$keyword}%")
                    ->orWhere(\DB::raw('concat(lastname," ",firstname)'), 'LIKE', "%{$keyword}%");
                })->orWhere(function ($query) use ($keyword) {
                    $query->where('username', 'LIKE', "%{$keyword}%")->whereNotIn('role',['Scholar','Administrator']);
                });
            })
            ->when($request->laboratory, function ($query, $laboratory) {
                $query->whereHas('myrole',function ($query) use ($laboratory) {
                    $query->where('laboratory_id',$laboratory);
                });
            })
            ->when($request->type, function ($query, $type) {
                $query->whereHas('myrole',function ($query) use ($type) {
                    $query->where('laboratory_type',$type);
                });
            })
            ->where('role','Staff')
            ->paginate($request->count)
        );
        return $data;
    }

    public function roles($request){
        $data = ListRole::when($request->keyword, function ($query, $keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        })->paginate($request->count);
        return DefaultResource::collection($data);
    }

    public function menus($request){
        $data = ListMenu::when($request->keyword, function ($query, $keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        })->paginate($request->count);
        return DefaultResource::collection($data);
    }

    public function authentications($request){
        $data = AuthenticationLog::with('user.profile')->orderBy('created_at','asc')->paginate($request->count);
        return AuthenticationResource::collection($data);
    }

    public function backups($request){
        $files = Storage::files('ONELAB');
        $fileDetails = collect($files)->map(function ($file) {
            return [
                'name' => basename($file),
                'path' => $file,
                'size' => $this->formatSizeUnits(Storage::size($file)),
                // 'url' => route('file.show', ['filename' => basename($file)]),
                'date' => Carbon::createFromTimestamp(Storage::lastModified($file))->format('M d, Y g:i a'),
            ];
        })->sortByDesc(function ($file) {
            return $file['date'];
        })->values();
        return $fileDetails->toJson();
    }

    public function formatSizeUnits($bytes){
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function backupdownload($name){
        $filePath = '/app/ONELAB/' . $name;
        return $this->streamFile($filePath);
    }

    private function streamFile($filePath){
        return new StreamedResponse(function () use ($filePath) {
            $stream = fopen(storage_path($filePath), 'rb');
            while (!feof($stream)) {
                echo fread($stream, 1024);
            }
            fclose($stream);
        }, 200, [
            'Content-Type' => mime_content_type(storage_path($filePath)),
            'Content-Disposition' => 'attachment; filename="' . basename($filePath) . '"',
        ]);
    }
}

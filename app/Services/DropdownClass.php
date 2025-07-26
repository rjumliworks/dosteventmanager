<?php

namespace App\Services;

use App\Models\User;
use App\Models\Speakers;
use App\Models\ListDropdown;
use App\Models\LocationRegion;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Models\LocationBarangay;

class DropdownClass
{  
    public function dropdowns($class,$type = null){
        $data = ListDropdown::where('classification',$class)
        ->when($type, function ($query) use ($type){
            $query->where('type',$type);
        })
        ->where('is_active',1)
        ->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'others' => $item->others,
                'type' => $item->type
            ];
        });
        return $data;
    }

    public function regions(){
        $data = LocationRegion::all()->map(function ($item) {
            return [
                'value' => $item->code,
                'name' => $item->region
            ];
        });
        return $data;
    }

    public function provinces($code){
        $data = LocationProvince::where('region_code',$code)->get()->map(function ($item) {
            return [
                'value' => $item->code,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function municipalities($code){
        $data = LocationMunicipality::where('province_code',$code)->get()->map(function ($item) {
            return [
                'value' => $item->code,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function barangays($code){
        $data = LocationBarangay::where('municipality_code',$code)->get()->map(function ($item) {
            return [
                'value' => $item->code,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function users($keyword){
        $data =  User::with('profile')
        ->when($keyword, function ($query) use ($keyword){
            $query->whereHas('profile', function ($query) use ($keyword) {
                $query->whereRaw('concat(firstname, " ", lastname) LIKE ?', ['%' . $keyword . '%'])
                    ->orWhereRaw('concat(lastname, " ", firstname) LIKE ?', ['%' . $keyword . '%']);
            });
        })
        ->where('role','Session Manager')
        ->limit(20)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->profile->lastname . ', ' . $item->profile->firstname . ' ' . $item->profile->middlename . '.',
                'avatar' => ($item->profile->avatar != 'avatar.jpg') ? '/storage/profile-pictures/'.$item->profile->avatar : '/images/avatars/avatar.jpg'
            ];
        });
        return $data;
    }

    public function speakers($keyword){
        $data =  Speakers::
        when($keyword, function ($query) use ($keyword){
            $query->where('name', 'LIKE', '%' . $keyword . '%');
        })
        ->limit(50)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'title' => $item->title,
                'establishment' => $item->establishment
            ];
        });
        return $data;
    }
}

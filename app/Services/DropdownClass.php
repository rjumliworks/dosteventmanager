<?php

namespace App\Services;

use App\Models\User;
use App\Models\ListUnit;
use App\Models\ListData;
use App\Models\ListRole;
use App\Models\ListStatus;
use App\Models\ListLeave;
use App\Models\ListPosition;
use App\Models\ListDeduction;
use App\Models\ListSalary;
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

    public function leaves(){
       $data = ListLeave::where('is_active', 1)->get()->map(function ($item) {
            if ($item->requires_balance === 1) {
                return [
                    'label' => 'Require Credits',
                    'options' => [
                        'value' => $item->id,
                        'name' => $item->name,
                        'citation' => $item->citation,
                        'is_regular' => $item->is_regular,
                        'is_increasing' => $item->is_increasing,
                        'is_after' => $item->is_after,
                        'is_active' => $item->is_active,
                        'requires_balance' => $item->requires_balance
                    ]
                ];
            } else if($item->requires_balance === 0) {
                return [
                    'label' => 'Require Documents',
                    'options' => [
                        'value' => $item->id,
                        'name' => $item->name,
                        'citation' => $item->citation,
                        'is_regular' => $item->is_regular,
                        'is_increasing' => $item->is_increasing,
                        'is_after' => $item->is_after,
                        'is_active' => $item->is_active,
                        'requires_balance' => $item->requires_balance
                    ]
                ];
            }else{
                   return [
                    'label' => 'Others',
                    'options' => [
                        'value' => $item->id,
                        'name' => $item->name,
                        'citation' => $item->citation,
                        'is_regular' => $item->is_regular,
                        'is_increasing' => $item->is_increasing,
                        'is_after' => $item->is_after,
                        'is_active' => $item->is_active,
                        'requires_balance' => $item->requires_balance
                    ]
                ];
            }
        });
        $grouped = $data->groupBy('label')->map(function ($items) {
            return [
                'label' => $items->first()['label'],
                'options' => $items->pluck('options')->values()
            ];
        })->values();

        return $grouped;
    }



    public function doctypes(){
        $data = ListData::where('type','Document Type')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function docactions(){
        $data = ListData::where('type','Document Action')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function levels(){
        $data = ListData::where('type','Level')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function eligibilities(){
        $data = ListData::where('type','Eligibility')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function licenses(){
        $data = ListData::where('type','License')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function types(){
        $data = ListData::where('type','Type')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function statuses(){
        $data = ListStatus::where('classification','Status')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'type' => $item->type,
                'color' => $item->color,
                'color' => $item->others,
            ];
        });
        return $data;
    }

    public function positions(){
        $data = ListPosition::with('salary')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'salary_id' => $item->salary_id,
                'year' => $item->salary->year,
                'is_regular' => $item->is_regular
            ];
        });
        return $data;
    }

    public function deductions(){
        $data = ListDeduction::get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => ($item->subtype != 'n/a') ? $item->name.' ('.$item->subtype.')' : $item->name,
                'subtype' => $item->subtype,
                'is_regular' => $item->is_regular,
                'is_contribution' => $item->is_contribution,
                'is_loan' => $item->is_loan,
                'is_enrollable' => $item->is_enrollable
            ];
        });
        return $data;
    }

    public function salaries(){
        $data = ListSalary::orderBy('grade','ASC')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => 'SG '.$item->grade.' ('.$item->amount.')',
                'grade' => $item->grade,
                'amount' => $item->amount, 
                'year' => $item->year,
                'is_regular' => $item->is_regular
            ];
        });
        return $data;
    }

    public function semesters(){
        $data = ListDropdown::where('classification','Period')->where('type','Semester')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'others' => $item->others
            ];
        });
        return $data;
    }

    public function stations(){
        $data = ListDropdown::where('classification','Station')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name.' ('.$item->others.')',
                'others' => $item->others
            ];
        });
        return $data;
    }

    public function divisions(){
        $data = ListDropdown::where('classification','Division')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'others' => $item->others
            ];
        });
        return $data;
    }

    public function religions(){
        $data = ListData::where('type','Religion')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function bloods(){
        $data = ListData::where('type','Blood Type')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function maritals(){
        $data = ListData::where('type','Marital Status')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function employment_statuses(){
        $data = ListData::where('type','Employment Status')->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name
            ];
        });
        return $data;
    }

    public function roles(){
        $data = ListRole::where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'has_lab' => $item->has_lab
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

    public function units($code){
        $data = ListUnit::where('division_id',$code)->where('is_active',1)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'short' => $item->short
            ];
        });
        return $data;
    }

    public function users($keyword,$is_regular){
        $data =  User::with('profile')
        ->with('organization.position')
        ->when($is_regular == 1, function ($query) {
            $query->whereHas('organization', function ($query) {
                $query->where('type_id', 15);
            });
        })
        ->when($keyword, function ($query) use ($keyword){
            $query->whereHas('profile', function ($query) use ($keyword) {
                $query->whereRaw('concat(firstname, " ", lastname) LIKE ?', ['%' . $keyword . '%'])
                    ->orWhereRaw('concat(lastname, " ", firstname) LIKE ?', ['%' . $keyword . '%']);
            });
        })
        ->limit(5)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->profile->lastname . ', ' . $item->profile->firstname . ' ' . $item->profile->middlename . '.',
                'position' => $item->organization->position->name,
                'avatar' => ($item->profile->avatar != 'avatar.jpg') ? '/storage/profile-pictures/'.$item->profile->avatar : '/images/avatars/avatar.jpg'
            ];
        });
        return $data;
    }
}

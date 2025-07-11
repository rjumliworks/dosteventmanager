<?php

namespace App\Services\Hr\Employee;

use Hashids\Hashids;
use App\Models\User;
use App\Models\ListData;
use App\Models\UserOrganization;
use App\Http\Resources\Hr\EmployeeResource;

class ViewClass
{
    public function counts(){
        $statuses = ListData::where('is_active',1)->where('type','Employment Status')->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
                'count' => UserOrganization::where('type_id',$item->id)->count()
            ];
        });
        return $statuses;
    }

    public function lists($request){
        $data = EmployeeResource::collection(
            User::select('users.id','email','username','users.created_at')
            ->with('profile.religion','profile.blood','profile.marital')
            ->with('organization.division','organization.position','organization.unit','organization.station','organization.type','organization.status','organization.salary')
            ->with('information','academics','credentials')
            ->join('user_profiles', 'user_profiles.user_id', '=', 'users.id')
            ->when($request->keyword, function ($query, $keyword) {
                $query->whereHas('profile',function ($query) use ($keyword) {
                    $query->when($keyword, function ($query, $keyword) {
                        $query->whereRaw('concat(firstname, " ", lastname) LIKE ?', ['%' . $keyword . '%'])
                            ->orWhereRaw('concat(lastname, " ", firstname) LIKE ?', ['%' . $keyword . '%']);
                    });
                })
                ->orWhere('username', 'like', "%{$keyword}%");
            })
            ->whereHas('organization',function ($query) use ($request) {
                $query->when($request->status, function ($query, $status) {
                    $query->where('status_id',$status);
                });
                $query->when($request->type, function ($query, $type) {
                    $query->where('type_id',$type);
                });
                $query->when($request->position, function ($query, $position) {
                    $query->where('position_id',$position);
                });
                $query->when($request->division, function ($query, $division) {
                    $query->where('division_id',$division);
                });
                $query->when($request->station, function ($query, $station) {
                    $query->where('station_id',$station);
                });
            })
            ->orderBy('user_profiles.lastname', 'ASC')
            ->paginate($request->count)
        );
        return $data;
    }

    public function view($code){
        $hashids = new Hashids('krad',10);
        $id = $hashids->decode($code);

        $data = new EmployeeResource(
            User::query()
            ->with('profile.religion','profile.blood','profile.marital')
            ->with('deductions.deduction')
            ->with('contracts.division','contracts.position','contracts.unit','contracts.station','contracts.type','contracts.status')
            ->with('organization.division','organization.position','organization.unit','organization.station','organization.type','organization.status','organization.salary')
            ->with('information','academics.level','credentials.type','credentials.name')
            ->where('id',$id)->first()
        );
        return $data;
    }
}

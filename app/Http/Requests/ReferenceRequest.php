<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch($this->option){
            case 'province':
                return [
                    'code' => 'sometimes|required|max:20|unique:location_provinces,code,'.$this->id,
                    'name' => 'sometimes|required|max:150|unique:location_provinces,name,'.$this->id,
                    'old_name' => 'nullable',
                    'region_code' => 'sometimes|required',
                ];
            break;
            case 'dropdown':
                return [
                    'name' => 'required|max:100|unique:list_dropdowns,name,NULL,'.$this->id.',classification,'.$this->classification,
                    'classification' => 'required|max:100',
                    'type' => 'required',
                    'color' => 'nullable',
                    'others' => 'nullable',
                ];
            break;
            case 'agency':
                return [
                    'name' => 'required|max:200|unique:list_agencies,name,'.$this->id,
                    'code' => 'required|max:200|unique:list_agencies,code,'.$this->id,
                    'acronym' => 'required|max:200|unique:list_agencies,acronym,'.$this->id,
                    'avatar' => 'nullable',
                    'region_code' => 'required',
                ];
            break;
            case 'privilege':
                return [
                    'name' => 'sometimes|required|max:200|unique:list_privileges,name,'.$this->id,
                    'type' => 'sometimes|required|string',
                    'short' => 'sometimes|required|string',
                    'regular_amount' => 'sometimes|required',
                    'summer_amount' => 'sometimes|required',
                    'is_fixed' => 'sometimes|required',
                    'is_reimburseable' => 'sometimes|required',
                ];
            break; 
            case 'status':
                return [
                    'name' => 'sometimes|required|max:200|unique:list_statuses,name,'.$this->id,
                    'type' => 'sometimes|required|string',
                    'color' => 'sometimes|required|string',
                    'others' => 'sometimes|required|string',
                ];
            break;
            case 'program':
                return [
                    'name' => 'sometimes|required|max:200|unique:list_programs,name,NULL,'.$this->id.',program_id,'.$this->program_id,
                    'is_sub' => 'sometimes|required',
                    'program_id' => 'sometimes|required|integer',
                ];
            break;
        }
    }
}

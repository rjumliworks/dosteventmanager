<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExecutiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch($this->option){
            case 'user':
                return [
                    'username' => 'sometimes|required|max:20|unique:users,username,'.$this->id,
                    'email' => 'sometimes|required|email|max:150|unique:users,email,'.$this->id,
                    'firstname' => 'sometimes|required|string|max:100',
                    'lastname' => 'sometimes|required|string|max:100',
                    'middlename' => 'sometimes|required|string|max:50',
                    'suffix' => 'sometimes|nullable|string|max:10',
                    'gender' => 'sometimes|required|string|max:6',
                    'mobile' => 'sometimes|required|numeric|digits:11|unique:user_profiles,mobile,'.$this->profile_id,
                    'laboratory_id' => 'sometimes|required'
                ];
            break;
            case 'menu':
                return [
                    'name' => 'required|unique:list_roles,name,'.$this->id,
                    'icon' => 'required',
                    'route' => 'required_if:has_child,false',
                    'path' => 'required',
                    'group' => 'required',
                    'submenus' => [
                        'required_if:has_child,true',
                        'array', 
                    ],
                    'submenus.*.name' => 'required_if:has_child,true',
                    'submenus.*.route' => 'required_if:has_child,true',
                    'submenus.*.path' => 'required_if:has_child,true',
                ];
            break;
            case 'role':
                return [
                    'name' => 'required',
                    'description' => 'required'
                ];
            break;
            default: 
                return [];
        }
    }

    public function messages()
    {
        switch($this->option){
            case 'menu':
                return [
                    'name.required' => 'Name required',
                    'name.unique' => 'Already been taken.',
                    'icon.required' => 'Icon required',
                    'route.required_if' => 'Route required',
                    'path.required' => 'Path required',
                    'group.required' => 'Group required',
                    'submenus.required_if' => 'The submenus field is required when has_child is true.',
                    'submenus.*.name.required_if' => 'The name field in submenus is required when has_child is true.',
                    'submenus.*.route.required_if' => 'The route field in submenus is required when has_child is true.',
                    'submenus.*.path.required_if' => 'The path field in submenus is required when has_child is true.',
                ];
            break;
            default: 
                return [];
        }
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        switch($this->option){
            case 'school':
                return [
                    'name' => 'required|unique:schools,name,'.$this->id,
                    'class_id' => 'required|integer',
                    'shortcut' => 'required',
                    'combiner' => 'nullable',
                    'campuses' => ['required','array'],
                    'campuses.*.name' => 'required|string',
                    'campuses.*.address' => 'required|string',
                    'campuses.*.grading_id' => 'required|integer',
                    'campuses.*.term_id' => 'required|integer',
                    'campuses.*.agency_id' => 'required|integer',
                ];
            break;
            case 'campus':
                return [
                    'campus' => 'required|string',
                    'address' => 'required|string',
                    'grading_id' => 'required|integer',
                    'term_id' => 'required|integer',
                    'agency_id' => 'required|integer'
                ];
            break;
            default: 
                return [];
        }
    }

    public function messages()
    {
        switch($this->option){
            case 'school':
                return [
                    'class_id.required' => '* required',
                    'shortcut.required' => '* required',
                    'campuses.required' => 'Need atleast 1 campus.',
                    'campuses.*.name.required' => '* required',
                    'campuses.*.address.required' => '* required',
                    'campuses.*.grading_id.required' => '* required',
                    'campuses.*.term_id.required' => '* required',
                    'campuses.*.agency_id.required' => '* required',
                ];
            break;
            default: 
                return [];
        }
    }
}

<?php

namespace App\Http\Requests\Operation;

use App\Rules\NotZeroPeso;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $laboratory = (\Auth::user()->myrole) ? \Auth::user()->myrole->laboratory_id : null;
        return [
            'code' => [
            'sometimes',
            'required',
            Rule::unique('equipment')
                ->ignore($this->id)
                ->where('laboratory_id', $laboratory),
        ],
            'name' => 'sometimes|required',
            'manufacturer' => 'sometimes|nullable',
            'serial_no' => 'sometimes|nullable',
            'model' => 'sometimes|nullable',
            'others' => 'sometimes|nullable',
            'supplier_id' => 'sometimes|nullable',
            'price' => ['sometimes','required', new NotZeroPeso],
            'laboratory_type' => 'sometimes|required',
            'acquired_at' => 'sometimes|nullable',
            'calibration_testpoints' => 'sometimes|nullable',
            'calibration_program' => 'sometimes|required',
            'maintenance_plan' => 'sometimes|required',
        ];
    }

    public function messages()
    {
        return [
            'maintenance_plan.required' => 'required',
            'calibration_program.required' => 'required',
            'laboratory_type.required' => 'required',
        ];
    }
}

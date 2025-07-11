<?php

namespace App\Http\Requests\HumanResource;

use App\Rules\NotZeroPeso;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PayrollRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
         switch($this->option){
            case 'cycle':
                return [
                    'month' => [
                        'sometimes',
                        'required',
                        Rule::unique('payroll_cycles')->where(function ($query) {
                            return $query->where('is_regular', 1)
                                        ->where('year', $this->year);
                        })
                    ],
                    'year' => 'sometimes|required',
                    'start' => 'sometimes|required',
                    'end' => 'sometimes|required',
                    'is_regular' => 'sometimes|required',
                ];
            break;
            case 'deduction':
                return [
                    'payroll_id' => [
                        'sometimes',
                        'required',
                    ],
                    'deduction_id' => [
                        'sometimes',
                        'required',
                        Rule::unique('payroll_deductions')->where(function ($query) {
                            return $query->where('payroll_id', $this->payroll_id);
                        }),
                    ],
                    'amount' => ['sometimes','required', new NotZeroPeso],
                ];
            break;
            case 'users':  
                return [
                    'type' => ['required', 'string'],
                    'users' => [
                        'required_if:type,Custom Employees,Except Employees',
                        'array',
                    ],
                    'users.*' => ['integer'],
                ];
            break;
            default: 
                return [];
        }
    }

    public function withValidator($validator)
    {
        if ($this->option === 'users') {
            $validator->sometimes('users', ['min:1'], function ($input) {
                return in_array($input->type, ['Custom Employees', 'Except Employees']);
            });
        }
    }
}

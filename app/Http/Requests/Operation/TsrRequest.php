<?php

namespace App\Http\Requests\Operation;

use Illuminate\Foundation\Http\FormRequest;

class TsrRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer' => 'sometimes|required',
            'conforme' => 'sometimes|required',
            'conforme_id' => 'sometimes|required',
            'purpose_id' => 'sometimes|required|integer',
            'laboratory_id' => 'sometimes|required|integer',
            'laboratory_type' => 'sometimes|required',
            'discount_id' => 'sometimes|required|integer',
            'due_at' => 'sometimes|required',
            'is_government' => 'sometimes|required_if:industry,Government'
        ];
    }
}

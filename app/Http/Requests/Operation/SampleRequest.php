<?php

namespace App\Http\Requests\Operation;

use Illuminate\Foundation\Http\FormRequest;

class SampleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required',
            'customer_description' => 'sometimes|required',
            'description' => 'nullable',
            'tsr_id' => 'sometimes|required',
        ];
    }
}

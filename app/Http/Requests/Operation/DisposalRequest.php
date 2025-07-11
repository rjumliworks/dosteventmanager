<?php

namespace App\Http\Requests\Operation;

use Illuminate\Foundation\Http\FormRequest;

class DisposalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sample' => 'required',
            'disposal_id' => 'required',
            'disposed_at' => 'required'
        ];
    }
}

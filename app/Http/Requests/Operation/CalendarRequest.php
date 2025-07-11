<?php

namespace App\Http\Requests\Operation;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => 'required',
            'title' => 'required',
            'venue' => [
                function ($attribute, $value, $fail) {
                    if (!in_array($this->type, ['Holiday', 'Leave']) && empty($value)) {
                        $fail('The venue field is required');
                    }
                },
            ],
            'description' => 'required'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'sometimes|required|email|max:150|unique:participants,email_hash,'.$this->id,
            'firstname' => 'sometimes|required|string|max:100',
            'lastname' => 'sometimes|required|string|max:100',
            'middlename' => 'sometimes|required|string|max:50',
            'suffix' => 'sometimes|nullable|string|max:10',
            'sex_id' => 'sometimes|required|integer',
            'birthdate' => 'sometimes|required',
            'contact_no' => [
                'sometimes',
                'required',
                'numeric',
                'digits:11',
                function ($attribute, $value, $fail) {
                    $hash = hash('sha256', $value);

                    $exists = \App\Models\Participant::where('contact_no_hash', $hash)
                        ->when($this->id, fn ($q) => $q->where('id', '!=', $this->id)) // ignore current record on update
                        ->exists();

                    if ($exists) {
                        $fail('The contact number has already been taken.');
                    }
                },
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $hash = hash('sha256', $value);

                    $exists = \App\Models\Participant::where('email_hash', $hash)
                        ->when($this->id, fn ($q) => $q->where('id', '!=', $this->id)) // ignore current record on update
                        ->exists();

                    if ($exists) {
                        $fail('The email has already been taken.');
                    }
                },
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $data = $this->all();

            if (empty($data['firstname']) || empty($data['middlename']) || empty($data['lastname'])) {
                $validator->errors()->add('fullname', 'Full name (first, middle, and last) is required.');
            }
        });
    }
}

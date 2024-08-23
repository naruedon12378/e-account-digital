<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            // "code" => "bail|required|max:100",
            // 'registration_number' => 'bail|required|max:100',
            'name' => 'bail|required|max:100',
            // 'address' => 'required|max:100',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "primary_account_id" => "required",
            "secondary_account_id" => "required",
            "sub_account_id" => "required",
            "account_code" => "bail|required|max:20",
            "name_th" => "bail|required|max:255",
            "name_en" => "bail|required|max:255",
        ];
    }
}

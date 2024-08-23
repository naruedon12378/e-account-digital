<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuotationRequest extends FormRequest
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
            "reference" => "bail|required|max:50",
            "quotation_number" => "bail|required|max:20",
            "customer_id" => "required",
            "issue_date" => "required",
            "expire_date" => "required",
            "currency_code" => "required",
        ];
    }
}

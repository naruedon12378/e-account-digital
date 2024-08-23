<?php

namespace App\Http\Requests\warehouse;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequistionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'doc_number' => 'unique:invoices,doc_number',
            'company_id' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'doc_number.unique' => 'Document number must be unique',
            'company_id.required' => 'Company is required',
        ];
    }
}

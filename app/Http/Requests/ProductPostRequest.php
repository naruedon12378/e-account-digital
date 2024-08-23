<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductPostRequest extends FormRequest
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
            "code" => "bail|required|max:100",
            "name_en" => "bail|required|max:255",
            "name_th" => "bail|max:255", 
            "type" => "max:100",
            "barcode_symbology" => ['required_if:is_barcode,true'],
            "barcode_symbology" => "max:191",
            "unit_id" => 'required',
            "sale_price" => ['required_if:item_class,advance'],
            "sale_price" => "required|numeric|min:0",
            "purchase_price" => ['required_if:item_class,advance'],
            "purchase_price" => "required|numeric|min:0",
            "sale_tax_id" => ['required_if:item_class,advance'],
            "purchase_tax_id" => ['required_if:item_class,advance'],
            "sale_account_id" => ['required_if:item_class,advance'],
            "purchase_account_id" => ['required_if:item_class,advance'],
            "cost_account_id" => [Rule::requiredIf(function(){
                return $this->input('item_class') == "advance" && $this->input('is_cost_calculation') == "true";
            })],
            "cost_calculation" => [Rule::requiredIf(function(){
                return $this->input('item_class') == "advance" && $this->input('is_cost_calculation') == "true";
            })],
            // "qty" => "nullable|numeric|min:0",
            // "min_qty" => "nullable|numeric|min:0",
        ];
    }
}

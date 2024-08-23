<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UnitSetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $rules = [];
        if( $this->isMethod('PUT') ||  $this->isMethod('PATCH') ) {
            $rules = [
                'unit_parent_id' => [
                    'required',
                     Rule::unique('unit_sets')
                        ->where('company_id', Auth::user()->company_id)
                        ->where('unit_parent_id', null)
                        ->where('unit_id', $this->unit_parent_id)
                        ->ignore($this->unit_parent_id, 'unit_parent_id'),
                ],
            ];
        }else{
            $rules = [
                'unit_parent_id' => [
                    'required',
                    Rule::unique('unit_sets')
                        ->where('company_id', Auth::user()->company_id)
                        ->where('unit_parent_id', null)
                        ->where('unit_id', $this->unit_parent_id)
                ],
            ];
        }

        $rules +=  [
            "selected_units"    => "required|array|min:1",
            "selected_units.*"  => "numeric|min:1",
            "unit_amounts"    => "required|array|min:1",
            "unit_amounts.*"  => "numeric|min:1",
        ];

        return $rules;
    }

    public function messages()
    {
        return  [
            'unit_parent_id.required' => 'กรุณาเลือกหน่วยสินค้าหลัก',
            'unit_parent_id.unique' => 'มีหน่วยสินค้าหลักนี้แล้ว',
            'selected_units.required' => 'กรุณาเลือกหน่วยสินค้าย่อย',
            'selected_units.array' => 'กรุณาเลือกหน่วยสินค้าย่อย',
            'selected_units.min' => 'กรุณาเลือกหน่วยสินค้าย่อย',
            'selected_units.*.numeric' => 'กรุณาเลือกหน่วยสินค้าย่อย',
            'selected_units.*.min' => 'กรุณาเลือกหน่วยสินค้าย่อย',
            'unit_amounts.required' => 'กรุณาระบุจำนวนหน่วยสินค้าย่อย',
            'unit_amounts.array' => 'กรุณาระบุจำนวนหน่วยสินค้าย่อย',
            'unit_amounts.min' => 'กรุณาระบุจำนวนหน่วยสินค้าย่อย',
            'unit_amounts.*.numeric' => 'กรุณาระบุจำนวนหน่วยสินค้าย่อย',
            'unit_amounts.*.min' => 'กรุณาระบุจำนวนหน่วยสินค้าย่อย',
        ];
    }

    // protected function failedValidation(Validator $validator)
    // {

    //     $errors = $validator->errors()->toArray();

    //     $transformed = [];
    //     foreach ($errors as $field => $message) {
    //         if( !isset($msg) )
    //             $msg = $message[0];
    //         $transformed[] = [
    //             'input_name' => $field,
    //             'msg' => $message[0],
    //         ];
    //     }

    //     $response = new JsonResponse([
    //         'validation' => true,
    //         'status' => false,
    //         'msg' => 'The given data is invalid',
    //         'errors' => $transformed
    //     ], 422);

    //     throw new ValidationException($validator, $response);
    // }
}

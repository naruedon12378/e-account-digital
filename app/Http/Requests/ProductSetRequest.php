<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductSetRequest extends FormRequest
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
                'code' => [
                    'required',
                     Rule::unique('product_sets','code')
                        ->where('company_id', Auth::user()->company_id)
                        ->whereNull('deleted_at')
                        ->ignore($this->id, 'id'),
                ],
            ];
        }else{
            $rules = [
                'code' => [
                    'required',
                    Rule::unique('product_sets','code')
                        ->where('company_id', Auth::user()->company_id)
                        ->whereNull('deleted_at')
                ],
            ];
        }

        $rules +=  [
            // "code"    => "required",
            "name_th"    => "required",
            "selected_products"    => "required|array|min:1",
            "selected_products.*"  => "numeric|min:1",
            "product_amounts"    => "required|array|min:1",
            "product_amounts.*"  => "numeric|min:1",
        ];

        return $rules;
    }

    public function messages()
    {
        return  [
            'code.required' => 'กรุณากรอกรหัส',
            'code.unique' => 'มีรหัสชุดสินค้านี้แล้ว',
            'name_th.required' => 'กรุณากรอกชื่อ(ภาษาไทย)',
            // 'product_parent_id.required' => 'กรุณาเลือกสินค้าหลัก',
            // 'product_parent_id.unique' => 'มีสินค้าหลักนี้แล้ว',
            'selected_products.required' => 'กรุณาเลือกสินค้าส่วนประกอบ',
            'selected_products.array' => 'กรุณาเลือกสินค้าส่วนประกอบ',
            'selected_products.min' => 'กรุณาเลือกสินค้าส่วนประกอบ',
            'selected_products.*.numeric' => 'กรุณาเลือกสินค้าส่วนประกอบ',
            'selected_products.*.min' => 'กรุณาเลือกสินค้าส่วนประกอบ',
            'product_amounts.required' => 'กรุณาระบุจำนวนสินค้าส่วนประกอบ',
            'product_amounts.array' => 'กรุณาระบุจำนวนสินค้าส่วนประกอบ',
            'product_amounts.min' => 'กรุณาระบุจำนวนสินค้าส่วนประกอบ',
            'product_amounts.*.numeric' => 'กรุณาระบุจำนวนสินค้าส่วนประกอบ',
            'product_amounts.*.min' => 'กรุณาระบุจำนวนสินค้าส่วนประกอบ',
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

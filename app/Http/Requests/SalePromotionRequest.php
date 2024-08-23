<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SalePromotionRequest extends FormRequest
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
                     Rule::unique('sale_promotions','code')
                        ->where('company_id', Auth::user()->company_id)
                        ->whereNull('deleted_at')
                        ->ignore($this->id, 'id'),
                ],
            ];
        }else{
            $rules = [
                'code' => [
                    'required',
                    Rule::unique('sale_promotions','code')
                        ->where('company_id', Auth::user()->company_id)
                        ->whereNull('deleted_at')
                ],
            ];
        }

        $rules +=  [
            "name_th"    => "required",
            "discount_percent"    => "nullable|numeric|max:100",
            "discount_limit"    => "nullable|numeric",
            "discount_price"    => "nullable|numeric",
            "selected_products"    => "required|array|min:1",
            "selected_products.*"  => "numeric|min:1",
            "product_conditions"    => "required|array|min:1",
            "product_conditions.*"  => "min:1",
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
            'discount_percent.numeric' => 'จำนวนส่วนลดต้องเป็นตัวเลข',
            'discount_percent.max' => 'จำนวนส่วนลดต้องไม่เกิน 100%',
            'discount_limit.numeric' => 'จำนวนส่วนลดสูงสุดต้องเป็นตัวเลข',
            'discount_price.numeric' => 'จำนวนส่วนลดต้องเป็นตัวเลข',
            'selected_products.required' => 'กรุณาเลือกสินค้า',
            'selected_products.array' => 'กรุณาเลือกสินค้า',
            'selected_products.min' => 'กรุณาเลือกสินค้า',
            'selected_products.*.numeric' => 'กรุณาเลือกสินค้า',
            'selected_products.*.min' => 'กรุณาเลือกสินค้า',
            'product_conditions.required' => 'กรุณาเลือกเงือนไข',
            'product_conditions.array' => 'กรุณาเลือกเงือนไข',
            'product_conditions.min' => 'กรุณาเลือกเงือนไข',
            'product_conditions.*.min' => 'กรุณาเลือกเงือนไข',
            'product_amounts.required' => 'กรุณาระบุจำนวน',
            'product_amounts.array' => 'กรุณาระบุจำนวน',
            'product_amounts.min' => 'กรุณาระบุจำนวน',
            'product_amounts.*.numeric' => 'กรุณาระบุจำนวน',
            'product_amounts.*.min' => 'กรุณาระบุจำนวน',
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

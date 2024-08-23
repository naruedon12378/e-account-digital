<?php

namespace App\Http\Requests\warehouse;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InventoryLotRequest extends FormRequest
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
                "inventory_lot_id"    => "required",
                "remark"    => "required",
                "product_add_amounts.*"  => "nullable|numeric|min:0",
                "product_minus_amounts.*"  => "nullable|numeric|min:0",
            ];
        }else{
            $rules = [
                'lot_number' => [
                    'required',
                    Rule::unique('inventory_lots')
                        ->where('company_id', Auth::user()->company_id)
                        ->where('warehouse_id', $this->warehouse_id)
                ],
                "warehouse_id"    => "required",
                "selected_products"    => "required|array|min:1",
                "selected_products.*"  => "numeric|min:1",
                "product_amounts"    => "required|array|min:1",
                "product_amounts.*"  => "numeric|min:1",
                "product_cost_prices"    => "required|array|min:1",
                "product_cost_prices.*"  => "min:0",
            ];
        }

        // $rules +=  [    
        // ];

        return $rules;
    }

    public function messages()
    {
        return  [
            'lot_number.required' => 'กรุณากรอกหมายเลขล็อต',
            'lot_number.unique' => 'มีหมายเลขล็อตสินค้านี้แล้ว',
            'warehouse_id.required' => 'กรุณาเลือกคลังสินค้า',
            'discount_percent.numeric' => 'จำนวนส่วนลดต้องเป็นตัวเลข',
            'discount_percent.max' => 'จำนวนส่วนลดต้องไม่เกิน 100%',
            'discount_limit.numeric' => 'จำนวนส่วนลดสูงสุดต้องเป็นตัวเลข',
            'discount_price.numeric' => 'จำนวนส่วนลดต้องเป็นตัวเลข',
            'selected_products.required' => 'กรุณาเลือกสินค้า',
            'selected_products.array' => 'กรุณาเลือกสินค้า',
            'selected_products.min' => 'กรุณาเลือกสินค้า',
            'selected_products.*.numeric' => 'กรุณาเลือกสินค้า',
            'selected_products.*.min' => 'กรุณาเลือกสินค้า',
            'product_amounts.required' => 'กรุณาระบุจำนวน',
            'product_amounts.array' => 'กรุณาระบุจำนวน',
            'product_amounts.min' => 'กรุณาระบุจำนวน',
            'product_amounts.*.numeric' => 'กรุณาระบุจำนวน',
            'product_amounts.*.min' => 'กรุณาระบุจำนวน',
            'product_cost_prices.required' => 'กรุณากำหนดต้นทุนสินค้า',
            'product_cost_prices.array' => 'กรุณากำหนดต้นทุนสินค้า',
            'product_cost_prices.min' => 'กรุณากำหนดต้นทุนสินค้า',
            'product_cost_prices.*.min' => 'กรุณากำหนดต้นทุนสินค้า',
            'remark.required' => 'กรุณาระบุหมายเหตุ',
            'product_add_amounts.*.numeric' => 'จำนวนที่เพิ่มเข้า ต้องเป็นตัวเลข',
            'product_minus_amounts.*.numeric' => 'จำนวนที่ลบออก ต้องเป็นตัวเลข',
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

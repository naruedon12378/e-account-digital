<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InventoryRequest extends FormRequest
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
            // dd( 'dd', $this->warehouse_id , $this->product_id);
            $rules +=  [
                "warehouse_id" => "required|min:1",
                "product_id" => [
                    'required',
                    'min:1',
                    Rule::unique('inventories','product_id')
                        ->where('warehouse_id', $this->warehouse_id)
                        ->ignore($this->id, 'id'),
                ],
            ];
        }else{
            $rules = [
                "warehouse_id" => "required|min:1",
                "product_id" => [
                    'required',
                    'min:1',
                    Rule::unique('inventories','product_id')
                        ->where('warehouse_id', $this->warehouse_id)
                ],
            ];
        }

        $rules += [
            "limit_min_amount" => 'nullable|numeric|min:0',
            "limit_max_amount" => 'nullable|numeric|min:0',
        ];

        return $rules;
    }

    public function messages()
    {
        return  [
            'warehouse_id.required' => 'กรุณาเลือกคลังสินค้า',
            'warehouse_id.min' => 'กรุณาเลือกคลังสินค้า',
            'product_id.required' => 'กรุณาเลือกสินค้า',
            'product_id.min' => 'กรุณาเลือกสินค้า',
            'product_id.unique' => 'มีสินค้าในคลังสินค้าอยู่แล้ว',
            'limit_min_amount.numeric' => 'จำนวนต่ำสุดต้องไม่น้อยกว่า 0',
            'limit_min_amount.min' => 'จำนวนต่ำสุดต้องไม่น้อยกว่า 0',
            'limit_max_amount.numeric' => 'จำนวนสูงสุดต้องไม่น้อยกว่า 0',
            'limit_max_amount.min' => 'จำนวนสูงสุดต้องไม่น้อยกว่า 0',
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

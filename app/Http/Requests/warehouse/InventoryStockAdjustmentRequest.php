<?php

namespace App\Http\Requests\warehouse;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InventoryStockAdjustmentRequest extends FormRequest
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
        return [
            "adjust_amount" => "required|numeric|min:".-$this->remaining_amount.'|not_in:0',
            "remark" => 'required',
        ];
    }

    public function messages()
    {
        return  [
            'adjust_amount.required' => 'กรุณากรอกจำนวน',
            'adjust_amount.not_in' => 'จำนวนต้องเป็นตัวเลข',
            'adjust_amount.numeric' => 'จำนวนต้องเป็นตัวเลข',
            'adjust_amount.min' => 'จำนวนลดต้องไม่มากกว่าจำนวนคงเหลือ',
            'remark.required' => 'กรุณาระบุเหตุผล/หมายเหตุ',
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

<?php

namespace App\Http\Requests\warehouse;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class WarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard()->check();
    }
    public function rules(): array
    {
        return [
            "branch_id" => "required",
            "name_th" => "bail|required|max:255",
        ];
    }

    public function messages()
    {
        return  [
            'branch_id.required' => 'กรุณาเลือกสาขา',
            'name.required' => 'กรุณากรอกชื่อกลุ่มสินค้า',
            'name.max' => 'ชื่อสินค้าต้องมีจำนวนไม่เกิน 255 ตัวอักษร',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $errors = $validator->errors()->toArray();

        $transformed = [];
        foreach ($errors as $field => $message) {
            if( !isset($msg) )
                $msg = $message[0];
            $transformed[] = [
                'input_name' => $field,
                'msg' => $message[0],
            ];
        }

        $response = new JsonResponse([
            'validation' => true,
            'status' => false,
            'msg' => 'The given data is invalid',
            'errors' => $transformed
        ], 422);

        throw new ValidationException($validator, $response);
    }
}

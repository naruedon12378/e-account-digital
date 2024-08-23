<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProductTypeRequest extends FormRequest
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
            "name_th" => "bail|required|max:255",
        ];
    }

    public function messages()
    {
        return  [
            'name_th.required' => 'กรุณากรอกชื่อประเภทสินค้า',
            'name_th.max' => 'ชื่อสินค้าต้องมีจำนวนไม่เกิน 255 ตัวอักษร',
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

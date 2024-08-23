<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
class UnitPostRequest extends FormRequest
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
                    'max:50',
                     Rule::unique('units')->where('company_id', Auth::user()->company_id)->ignore($this->id)
                ],
            ];
        }else{
            $rules = [
                'code' => [
                    'required',
                    'max:50',
                    Rule::unique('units')->where('company_id', Auth::user()->company_id)
                ],
            ];
        }

        $rules +=  [
            "name_en" => "bail|required|max:191",
            "name_th" => "bail|required|max:191",
            "type" => "bail|required|max:20",
        ];

        return $rules;
    }

    public function messages()
    {
        return  [
            'code.required' => 'กรุณากรอกรหัส',
            'code.unique' => 'รหัสซ้ำ',
            'code.max' => 'รหัสไม่เกิน 50 ตัวอักษร',
            'name_en.required' => 'กรุณากรอกชื่อ(อังกฤษ)',
            'name_en.max' => 'ชื่อ(อังกฤษ)ไม่เกิน 190 ตัวอักษร',
            'name_th.required' => 'กรุณากรอกชื่อ(ไทย)',
            'name_th.max' => 'ชื่อ(ไทย)ไม่เกิน 190 ตัวอักษร',
            'type.required' => 'กรุณาเลือกประเภท',
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

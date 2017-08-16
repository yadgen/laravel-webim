<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class RegisterPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_name' => 'bail|required|between:3,15|unique:user',
            'password' => 'bail|required|min:6|confirmed',
            'email' => 'bail|required|between:7,40|unique:user',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute必填',
            'unique' => ':attribute重复',
            'between' => ':attribute长度必须大于等于:min且小于等于:max',
            'min' => ':attribute长度必须大于等于:min',
            'confirmed' => '两次输入的:attribute不一致',
        ];
    }

    public function attributes()
    {
        return [
            'user_name' => '用户名',
            'password' => '密码',
            'email' => '邮箱',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        if ($validator->fails()) {
            $error_message = $validator->messages()->first();

            return [
                0 => $error_message
            ];
        }
    }
}

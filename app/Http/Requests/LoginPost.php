<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginPost extends FormRequest
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
            'user_name' => 'bail|required|between:3,15',
            'password' => 'bail|required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attritube不能为空。',
            'unique' => ':attribute已经重复。',
            'between' => ':attribute长度必须大于等于:min且小于等于:max。',
            'min' => ':attribute长度必须大于等于:min。'
        ];
    }

    public function attributes()
    {
        return [
            'user_name' => '用户名',
            'password' => '密码'
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

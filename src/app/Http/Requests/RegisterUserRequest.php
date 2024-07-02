<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'ユーザー名は必須です。',
            'name.string' => 'ユーザー名は文字列でなければなりません。',
            'name.max' => 'ユーザー名は255文字以内でなければなりません。',
            'email.required' => 'メールアドレスは必須です。',
            'email.string' => 'メールアドレスは文字列でなければなりません。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内でなければなりません。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'password.required' => 'パスワードは必須です。',
            'password.string' => 'パスワードは文字列でなければなりません。',
            'password.min' => 'パスワードは8文字以上でなければなりません。',
            'password.confirmed' => 'パスワードの確認が一致しません。',
        ];
    }
}

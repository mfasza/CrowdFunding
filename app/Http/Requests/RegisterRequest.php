<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ["required"],
            'email' => ["required", 'email', "unique:users,email"]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Nama Wajib Diisi",
            'email.required' => "Email Wajib Diisi",
            'email.unique' => "Email sudah digunakan. Gunakan alamat email lain",
            'email.email' => "Isikan alamat email yang valid"
        ];
    }
}

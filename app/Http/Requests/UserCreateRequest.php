<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
    
    /**
     * Get the validation error message.
     *
     * @return array
     */
    public function message()
    {
        return [
            'first_name.required' => 'First name is required',
            'last_name.required' => 'last name is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Phone is required',
            'email.email' => 'Email is not valid email',
            'password.required' => 'Password is required',
            
        ];
    }
}

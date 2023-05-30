<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email|min:10|max:255',
            'password' => 'required|min:10|max:255',
            'firstname' => 'required|min:3|max:255',
            'lastname' => 'required|min:3|max:255',
            'dateOfBirth' => 'required|datetime',
            'genderId' => 'required',
            'rightId' => 'required'
        ];
    }
}

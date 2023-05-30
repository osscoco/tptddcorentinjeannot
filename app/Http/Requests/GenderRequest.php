<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class GenderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'label' => 'required|max:255'
        ];
    }
}

<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'isbn' => 'required|max:255',
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'editor' => 'required|max:255',
            'isAvailable' => 'required',
            'formatId' => 'required',
            'userId' => 'required'
        ];
    }
}

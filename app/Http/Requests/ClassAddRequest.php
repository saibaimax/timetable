<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassAddRequest extends FormRequest
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
            'name' => 'required|max:50',
            'teacher' => 'required|max:40',
            'room_number' => 'required|max:20'
        ];
    }
}

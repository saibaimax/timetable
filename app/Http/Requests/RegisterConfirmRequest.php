<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterConfirmRequest extends FormRequest
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
            'subject_id' => 'numeric|integer'
        ];
    }

    public function messages()
    {
        return [
            'subject_id.numeric' => '正しい:attributeを選択してください。',
            'subject_id.integer' => '正しい:attributeを選択してください。',
        ];
    }
}

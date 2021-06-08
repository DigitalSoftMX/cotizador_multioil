<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'rfc' => 'required|min:3',
            'delivery_address' => 'required|min:3',
            'fiscal_address' => 'required|min:3',
            'clabe' => 'required|min:3',
            'terminal_id' => 'required'
        ];
    }
}

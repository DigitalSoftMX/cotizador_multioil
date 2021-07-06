<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeRequest extends FormRequest
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
            'terminal_id' => 'required|integer',
            'company_id' => 'required|integer',
            'base_id' => 'required|integer',
            'regular_fit' => 'required|numeric',
            'premium_fit' => 'required|numeric',
            'diesel_fit' => 'required|numeric',
        ];
    }
}

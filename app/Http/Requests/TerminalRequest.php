<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TerminalRequest extends FormRequest
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
            'business_name' => 'required|min:3',
            'rfc' => 'required|min:3',
            'name' => 'required|min:3',
            'postcode' => 'required|integer',
            'kind_road' => 'required|min:3',
            'name_road' => 'required|min:3',
            'n_outsice' => 'required|integer',
            'settlement' => 'required|min:3',
            'location' => 'required|min:3',
            'town' => 'required|min:3',
            'state' => 'required|min:3',
        ];
    }
}

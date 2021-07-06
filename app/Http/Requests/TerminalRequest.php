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
            'name' => 'required|min:3',
            'postcode' => 'required|integer',
            'name_road' => 'required|min:3',
            'n_outsice' => 'required|string',
            'town' => 'required|min:3',
            'state' => 'required|min:3',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }
}

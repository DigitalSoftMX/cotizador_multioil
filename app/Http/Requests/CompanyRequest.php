<?php

namespace App\Http\Requests;

use App\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'alias' => 'required|min:3',
            'rfc' => 'required|min:3',
            'delivery_address' => 'required|min:3',
            'terminal_id' => 'required',
            'color' => 'required',
            'email' => [
                'required', 'email', Rule::unique((new Company)->getTable())->ignore($this->route()->company->id ?? null)
            ],
            'shipper' => 'required|numeric'
        ];
    }
}

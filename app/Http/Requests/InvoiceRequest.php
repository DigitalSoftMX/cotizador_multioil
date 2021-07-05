<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'dispatched' => 'required',
            'dispatched_liters' => 'required',
            'invoice' => 'required',
            'CFDI' => 'required',
            'name_freight' => 'required|min:3',
            'sale_price' => 'required|numeric',
            'price' => 'required|numeric'
        ];
    }
}

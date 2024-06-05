<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InitiateTransferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cnumber' => 'required|string',
            'refid' => 'required|string',
            'amount' => 'required|numeric', // Add other fields as needed
        ];
    }
}

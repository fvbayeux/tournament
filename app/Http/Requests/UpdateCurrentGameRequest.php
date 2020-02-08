<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrentGameRequest extends FormRequest
{
    public function rules()
    {
        return [
            'value' => 'required|integer|min:0',
        ];
    }
}

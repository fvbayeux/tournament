<?php

namespace App\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdatePlayerRequest extends FormRequest
{

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}

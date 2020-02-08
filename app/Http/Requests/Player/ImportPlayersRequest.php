<?php

namespace App\Http\Requests\Player;

use Illuminate\Foundation\Http\FormRequest;

class ImportPlayersRequest extends FormRequest
{
    public function rules()
    {
        return [
            'file' => 'required|file|mimes:txt'
        ];
    }
}

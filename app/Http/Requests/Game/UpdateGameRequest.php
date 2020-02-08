<?php

namespace App\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{

    public function rules()
    {
        return [
            'first_player_id' => 'nullable|integer|min:0|exists:players,id',
            'second_player_id' => 'nullable|integer|min:0|exists:players,id',
        ];
    }
}

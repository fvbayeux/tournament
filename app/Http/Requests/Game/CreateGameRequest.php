<?php

namespace App\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class CreateGameRequest extends FormRequest
{
    public function rules()
    {
        return [
            'number' => 'required|integer|unique:games,number',
            'first_player_id' => 'nullable|integer|min:0|exists:players,id',
            'second_player_id' => 'nullable|integer|min:0|exists:players,id',
        ];
    }
}

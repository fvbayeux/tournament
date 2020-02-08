<?php

namespace App\Http\Resources;

use App\Game;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Game
 */
class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'first_player_id' => $this->first_player_id,
            'second_player_id' => $this->second_player_id,
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Game;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Game
 */
class GameWithPlayersResource extends JsonResource
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
            'first_player' => new PlayerResource($this->whenLoaded('firstPlayer')),
            'second_player' => new PlayerResource($this->whenLoaded('secondPlayer')),
        ];
    }
}

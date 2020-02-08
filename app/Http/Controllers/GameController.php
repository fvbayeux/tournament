<?php

namespace App\Http\Controllers;

use App\Events\GamesUpdated;
use App\Game;
use App\Http\Requests\Game\CreateGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Http\Resources\GameWithPlayersResource;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::orderBy('number')->get();

        return GameResource::collection($games);
    }

    public function nextGames()
    {
        $games = Game::nextGames()
                     ->with(['firstPlayer', 'secondPlayer'])
                     ->get();

        return GameWithPlayersResource::collection($games);
    }

    public function create(CreateGameRequest $request)
    {
        Game::create($request->validated());

        safeBroadcast(new GamesUpdated());

        return $this->index();
    }

    public function update(UpdateGameRequest $request, Game $game)
    {
        $game->update($request->validated());

        safeBroadcast(new GamesUpdated());

        return $this->index();
    }
}

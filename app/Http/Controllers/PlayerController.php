<?php

namespace App\Http\Controllers;

use App\Events\GamesUpdated;
use App\Http\Requests\Player\CreateOrUpdatePlayerRequest;
use App\Http\Requests\Player\ImportPlayersRequest;
use App\Http\Resources\PlayerResource;
use App\Player;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::orderBy('name')->get();

        return PlayerResource::collection($players);
    }

    public function create(CreateOrUpdatePlayerRequest $request)
    {
        Player::create($request->validated());

        return $this->index();
    }

    public function import(ImportPlayersRequest $request)
    {
        $fileContent = $request->file('file')->get();

        foreach (explode(PHP_EOL, $fileContent) as $line) {
            $name = trim($line);
            if ($name) {
                Player::updateOrCreate(['name'=> Str::title($name)]);
            }
        }

        return redirect('/dashboard');
    }

    public function update(CreateOrUpdatePlayerRequest $request, Player $player)
    {
        $player->update($request->validated());

        if ($player->gamesAsFirst()->count() > 0 || $player->gamesAsSecond()->count() > 0) {
            safeBroadcast(new GamesUpdated());
        }

        return $this->index();
    }

    public function destroy(Player $player)
    {
        $player->delete();
        safeBroadcast(new GamesUpdated());

        return $this->index();
    }
}

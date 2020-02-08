<?php

namespace App\Http\Controllers;

use App\Events\CurrentGameUpdated;
use App\Http\Requests\UpdateCurrentGameRequest;
use App\Http\Resources\CurrentGameResource;
use App\Setting;

class CurrentGameController extends Controller
{
    public function show()
    {
        return new CurrentGameResource(Setting::currentGame());
    }

    public function update(UpdateCurrentGameRequest $request)
    {
        $currentGame = Setting::currentGame();
        $currentGame->update($request->validated());

        safeBroadcast(new CurrentGameUpdated($currentGame->value));

        return new CurrentGameResource($currentGame);
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\CurrentGameUpdated;
use App\Events\GamesUpdated;
use App\Game;
use App\Player;
use App\Setting;
use Illuminate\Http\Request;

class FlushController extends Controller
{
    public function flush(Request $request)
    {
        $this->validate($request, [
            "pass" => 'required|string|in:je prends le risque'
        ]);

        Setting::currentGame()->update(['value' => 0]);
        Game::truncate();
        Player::truncate();

        safeBroadcast(new CurrentGameUpdated(0));
        safeBroadcast(new GamesUpdated());

        return redirect('dashboard');
    }
}

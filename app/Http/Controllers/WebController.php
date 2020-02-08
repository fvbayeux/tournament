<?php

namespace App\Http\Controllers;

use App\Game;
use App\Setting;

class WebController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function dashboard()
    {
        return view('dashboard', ['currentGame' => Setting::currentGame()]);
    }

    public function counter()
    {
        return view('counter', ['currentGame' => Setting::currentGame()]);
    }

    public function games()
    {
        $games = Game::nextGames()
                     ->with(['firstPlayer', 'secondPlayer'])
                     ->get();

        return view('games', ['games' => $games]);
    }
}

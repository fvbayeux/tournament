<?php

namespace App\Console\Commands;

use App\Game;
use Illuminate\Console\Command;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bad:export-games {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export games to database/resources/{filename}';

    public function handle()
    {
        $filename = $this->argument('filename');

        $games = Game::with(['firstPlayer', 'secondPlayer'])
                     ->orderBy('id')
                     ->get();

        (new FastExcel($games))
            ->export(database_path("resources/$filename.csv"), function (Game $game) {

                return [
                    'number' => $game->number,
                    'first_player' => $game->first_player_id ? $game->firstPlayer->name : null,
                    'second_player' => $game->second_player_id ? $game->secondPlayer->name : null,
                ];
            });
    }
}

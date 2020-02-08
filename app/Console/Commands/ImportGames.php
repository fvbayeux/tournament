<?php

namespace App\Console\Commands;

use App\Game;
use App\Player;
use Illuminate\Console\Command;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bad:import-games {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import games from database/resources/{filename}.csv file';

    public function handle()
    {
        $filename = $this->argument('filename');

        Game::getQuery()->delete();

        (new FastExcel)->import(database_path("resources/$filename.csv"), function ($line) {

            $firstPlayer = $line['first_player']
                ? Player::firstOrCreate(['name' => $line['first_player']])->id
                : null;
            $secondPlayer = $line['second_player']
                ? Player::firstOrCreate(['name' => $line['second_player']])->id
                : null;
            Game::create([
                'number' => $line['number'],
                'first_player_id' => $firstPlayer,
                'second_player_id' => $secondPlayer,
            ]);
        });
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Player::class, 20)->create();

        for ($i = 0; $i < 5; $i++) {
            factory(\App\Game::class)->state('withPlayers')->create();
        }
        for ($i = 0; $i < 5; $i++) {
            factory(\App\Game::class)->state('withPlayer')->create();
        }
        for ($i = 0; $i < 5; $i++) {
            factory(\App\Game::class)->create();
        }
        factory(\App\Game::class)->create(['number' => 17]);
        factory(\App\Game::class)->create(['number' => 21]);
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('number');
            $table->unsignedInteger('first_player_id')->nullable();
            $table->unsignedInteger('second_player_id')->nullable();

            $table->timestamps();

            $table->foreign('first_player_id')
                  ->references('id')
                  ->on('players')
                  ->onDelete('set null');

            $table->foreign('second_player_id')
                ->references('id')
                ->on('players')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}

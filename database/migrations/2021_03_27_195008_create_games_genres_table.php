<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesGenresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games_genres', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')
                  ->references('id')
                  ->on('games')->onDelete('cascade');

            $table->integer('genre_id');
            $table->foreign('genre_id')
                  ->references('id')
                  ->on('genres')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games_genres');
    }
}

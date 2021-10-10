<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games_platforms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('game_id');
            $table->foreign('game_id')
                  ->references('id')
                  ->on('games')->onDelete('cascade');

            $table->integer('platform_id');
            $table->foreign('platform_id')
                  ->references('id')
                  ->on('platforms')->onDelete('cascade');

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
        Schema::dropIfExists('games_platforms');
    }
}

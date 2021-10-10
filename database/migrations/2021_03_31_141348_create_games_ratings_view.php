<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGamesRatingsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
          CREATE VIEW games_ratings AS
          (
            SELECT games.id game_id,
                CASE WHEN COUNT(ratings.id) = 0 THEN 0
                ELSE SUM(ratings.rating) / COUNT(ratings.id)
            END rating
            FROM games
            LEFT JOIN ratings ON ratings.game_id = games.id
            GROUP BY games.id
          )
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS games_ratings');
    }
}

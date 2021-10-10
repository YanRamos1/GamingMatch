<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateYearsView extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    if (env('APP_ENV', 'local') == 'local') {
      DB::statement("
          CREATE VIEW years AS
          (
            SELECT year(released_at) year
            FROM games
            GROUP by year(released_at)
            ORDER BY year(released_at) DESC
          )
        ");
    } else {
      DB::statement("
          CREATE VIEW years AS
          (
            SELECT date_part('year',released_at) AS year
            FROM games
            GROUP by date_part('year',released_at)
            ORDER BY date_part('year',released_at) DESC
          )
        ");
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    DB::statement('DROP VIEW IF EXISTS years');
  }
}

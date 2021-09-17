<?php
/**
 *  app\Modules\Event\Database\Migrations\2021_07_30_214548_add_price_table_to_event_sessions_table.php
 *
 * Date-Time: 7/30/2021
 * Time: 9:45 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceTableToEventSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_sessions', function (Blueprint $table) {
            $table->unsignedInteger('price')->after('max_person')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_sessions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}

<?php
/**
 *  app\Modules\Event\Database\Migrations\2021_07_25_183643_add_type_column_to_event_sessions_table.php
 *
 * Date-Time: 7/25/2021
 * Time: 6:36 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColumnToEventSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_sessions', function (Blueprint $table) {
            $table->unsignedInteger('type')->after('status')->default(100);
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

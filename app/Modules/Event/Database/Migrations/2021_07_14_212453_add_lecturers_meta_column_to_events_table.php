<?php
/**
 *  app\Modules\Event\Database\Migrations\2021_07_14_212453_add_lecturers_meta_column_to_events_table.php
 *
 * Date-Time: 7/14/2021
 * Time: 9:25 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddLecturersMetaColumnToEventsTable
 */
class AddLecturersMetaColumnToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->json('lecturers_meta')->nullable()->after('event_meta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('lecturers_meta');
        });
    }
}

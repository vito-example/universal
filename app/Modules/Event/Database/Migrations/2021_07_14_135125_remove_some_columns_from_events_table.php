<?php
/**
 *  app/Modules/Event/Database/Migrations/2021_07_14_135125_remove_some_columns_from_events_table.php
 *
 * Date-Time: 14.07.21
 * Time: 13:52
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSomeColumnsFromEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('organizers_meta');
            $table->dropColumn('sponsors_meta');
            $table->dropColumn('timezone');
            $table->dropColumn('speakers_meta');

            $table->dropForeign(['event_language_id']);
            $table->dropColumn('event_language_id');
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
            $table->dateTimeTz('start_date')->nullable();
            $table->json('organizers_meta')->nullable();
            $table->json('sponsors_meta')->nullable();
            $table->string('timezone')->nullable();
            $table->unsignedBigInteger('event_language_id')->index()->nullable();
            $table->json('speakers_meta')->nullable();

            $table->foreign('event_language_id')->references('id')->on('event_languages');
        });
    }
}

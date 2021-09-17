<?php
/**
 *  app/Modules/Event/Database/Migrations/2021_07_16_155020_drop_event_unused_relation_table.php
 *
 * Date-Time: 16.07.21
 * Time: 15:50
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropEventUnusedRelationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('events_attendees');
        Schema::dropIfExists('event_language_translations');
        Schema::dropIfExists('event_languages');
        Schema::dropIfExists('event_questions');
        Schema::dropIfExists('event_connections');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

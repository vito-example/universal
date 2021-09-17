<?php
/**
 *  app\Modules\Event\Database\Migrations\2021_07_25_124334_create_event_sessions_attendees_table.php
 *
 * Date-Time: 7/25/2021
 * Time: 12:45 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSessionsAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_sessions_attendees', function (Blueprint $table) {
            $table->unsignedBigInteger('session_id')->index();
            $table->unsignedBigInteger('person_con_id')->index();

            $table->foreign('session_id')->references('id')->on('event_sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('person_con_id')->references('id')->on('users_employees_connections')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->primary(['session_id','person_con_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_sessions_attendees');
    }
}

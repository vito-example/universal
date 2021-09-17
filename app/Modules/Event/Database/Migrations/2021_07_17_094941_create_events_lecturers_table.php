<?php
/**
 *  app\Modules\Event\Database\Migrations\2021_07_17_094941_create_events_lecturers_table.php
 *
 * Date-Time: 7/17/2021
 * Time: 9:50 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsLecturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events_lecturers', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->index();
            $table->unsignedBigInteger('lecturer_id')->index();

            $table->foreign('event_id')->references('id')->on('events')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('lecturer_id')->references('id')->on('lecturers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->primary(['event_id','lecturer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events_lecturers');
    }
}

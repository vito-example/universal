<?php
/**
 *  app\Modules\Event\Database\Migrations\2021_08_16_204056_create_event_session_attempts_table.php
 *
 * Date-Time: 8/16/2021
 * Time: 8:44 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSessionAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_session_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id')->index()->nullable();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->integer('person_total')->default(1);
            $table->softDeletes();


            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('session_id')
                ->references('id')
                ->on('event_sessions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('event_session_attemps');
    }
}

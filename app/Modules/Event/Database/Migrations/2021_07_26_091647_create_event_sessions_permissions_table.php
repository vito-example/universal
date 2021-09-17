<?php
/**
 *  app/Modules/Event/Database/Migrations/2021_07_26_091647_create_event_sessions_permissions_table.php
 *
 * Date-Time: 26.07.21
 * Time: 09:17
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSessionsPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_sessions_permissions', function (Blueprint $table) {
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
        Schema::dropIfExists('event_sessions_permissions');
    }
}
<?php
/**
 *  app/Modules/Event/Database/Migrations/2021_07_27_091803_create_event_sessions_users_table.php
 *
 * Date-Time: 27.07.21
 * Time: 09:18
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSessionsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('event_sessions_users', function (Blueprint $table) {
            $table->unsignedBigInteger('session_id')->index();
            $table->unsignedBigInteger('user_id')->index();

            $table->foreign('session_id')->references('id')->on('event_sessions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->primary(['session_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_sessions_users');
    }
}

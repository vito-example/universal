<?php
/**
 *  app/Modules/Event/Database/Migrations/2021_07_20_105214_add_max_person_column_to_event_sessions_table.php
 *
 * Date-Time: 20.07.21
 * Time: 10:52
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxPersonColumnToEventSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('event_sessions', function (Blueprint $table) {
            $table->integer('max_person')->default(1)->after('event_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('event_sessions', function (Blueprint $table) {
            //
        });
    }
}

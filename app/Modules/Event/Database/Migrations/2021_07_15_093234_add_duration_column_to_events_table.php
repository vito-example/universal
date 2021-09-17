<?php
/**
 *  app/Modules/Event/Database/Migrations/2021_07_15_093234_add_duration_column_to_events_table.php
 *
 * Date-Time: 15.07.21
 * Time: 09:32
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationColumnToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('duration')->nullable()->after('lecturers_meta');
            $table->unsignedInteger('type')->nullable()->after('status');
            $table->unsignedInteger('form')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
}

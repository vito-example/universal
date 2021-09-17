<?php
/**
 *  app/Modules/Event/Database/Migrations/2021_08_04_162351_add_syllabus_column_to_event_translations_table.php
 *
 * Date-Time: 04.08.21
 * Time: 16:24
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSyllabusColumnToEventTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_translations', function (Blueprint $table) {
            $table->longText('syllabus')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_translations', function (Blueprint $table) {
            $table->dropColumn('syllabus');
        });
    }
}

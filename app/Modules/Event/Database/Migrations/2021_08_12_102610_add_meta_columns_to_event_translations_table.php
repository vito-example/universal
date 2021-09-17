<?php
/**
 *  app/Modules/Event/Database/Migrations/2021_08_12_102610_add_meta_columns_to_event_translations_table.php
 *
 * Date-Time: 12.08.21
 * Time: 10:26
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaColumnsToEventTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_translations', function (Blueprint $table) {
            $table->json('seo_meta')->nullable();
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
            //
        });
    }
}

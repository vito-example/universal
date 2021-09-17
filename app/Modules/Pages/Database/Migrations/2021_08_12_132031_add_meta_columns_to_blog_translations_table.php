<?php
/**
 *  app/Modules/Pages/Database/Migrations/2021_08_12_132031_add_meta_columns_to_blog_translations_table.php
 *
 * Date-Time: 13.08.21
 * Time: 09:52
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMetaColumnsToBlogTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_translations', function (Blueprint $table) {
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
        Schema::table('blog_translations', function (Blueprint $table) {
            //
        });
    }
}

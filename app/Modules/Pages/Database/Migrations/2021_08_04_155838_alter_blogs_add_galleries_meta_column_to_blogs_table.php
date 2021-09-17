<?php
/**
 *  app/Modules/Pages/Database/Migrations/2021_08_04_155838_alter_blogs_add_galleries_meta_column_to_blogs_table.php
 *
 * Date-Time: 04.08.21
 * Time: 16:22
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBlogsAddGalleriesMetaColumnToBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->json('galleries_meta')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn([
                'galleries_meta'
            ]);
        });
    }
}

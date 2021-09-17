<?php
/**
 *  app/Modules/Customer/Database/Migrations/2021_07_06_152823_create_direction_translations_table.php
 *
 * Date-Time: 06.07.21
 * Time: 15:31
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direction_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('direction_id')
                ->unsigned();
            $table->foreign('direction_id')
                ->references('id')
                ->on('directions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('locale')
                ->index();

            $table->unique(['direction_id','locale']);


            $table->string('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direction_translations');
    }
}

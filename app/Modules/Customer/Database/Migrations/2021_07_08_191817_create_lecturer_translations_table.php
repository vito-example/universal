<?php
/**
 *  app\Modules\Customer\Database\Migrations\2021_07_08_191817_create_lecturer_translations_table.php
 *
 * Date-Time: 7/8/2021
 * Time: 7:18 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturer_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('lecturer_id')
                ->unsigned();
            $table->foreign('lecturer_id')
                ->references('id')
                ->on('lecturers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('locale')
                ->index();

            $table->unique(['lecturer_id','locale']);


            $table->string('full_name')->nullable();
            $table->longText('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecturer_translations');
    }
}

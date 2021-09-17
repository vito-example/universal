<?php
/**
 *  app\Modules\Customer\Database\Migrations\2021_07_08_195154_create_lecturers_directions_table.php
 *
 * Date-Time: 7/8/2021
 * Time: 9:10 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturersDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lecturers_directions', function (Blueprint $table) {
            $table->unsignedBigInteger('lecturer_id')->index();
            $table->unsignedBigInteger('direction_id')->index();

            $table->foreign('lecturer_id')->references('id')->on('lecturers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('direction_id')->references('id')->on('directions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->primary(['lecturer_id','direction_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lecturers_directions');
    }
}

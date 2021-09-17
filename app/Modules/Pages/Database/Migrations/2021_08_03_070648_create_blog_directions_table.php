<?php
/**
 *  app\Modules\Pages\Database\Migrations\2021_08_03_070648_create_blog_directions_table.php
 *
 * Date-Time: 8/3/2021
 * Time: 7:07 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_directions', function (Blueprint $table) {
            $table->unsignedBigInteger('blog_id')->index();
            $table->unsignedBigInteger('direction_id')->index();

            $table->foreign('blog_id')->references('id')->on('blogs')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('direction_id')->references('id')->on('directions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->primary(['blog_id','direction_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_directions');
    }
}

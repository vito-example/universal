<?php
/**
 *  app/Modules/Customer/Database/Migrations/2021_07_06_152458_create_directions_table.php
 *
 * Date-Time: 06.07.21
 * Time: 15:25
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateDirectionsTable
 */
class CreateDirectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                ->unsigned()
                ->nullable()
                ->constrained('directions')
                ->onDelete('set null');
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directions');
    }
}

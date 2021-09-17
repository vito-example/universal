<?php
/**
 *  app\Modules\Company\Database\Migrations\2021_07_25_110632_create_users_employees_connections_table.php
 *
 * Date-Time: 7/25/2021
 * Time: 11:06 AM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersEmployeesConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_employees_connections', function (Blueprint $table) {
            $table->id();
            $table->morphs('morphable');
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_employees_connections');
    }
}

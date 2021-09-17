<?php
/**
 *  app\Modules\Company\Database\Migrations\2021_08_07_125235_alter_companies_table.php
 *
 * Date-Time: 8/7/2021
 * Time: 12:53 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('identity_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->string('identity_id', 100)->index()->nullable();
        });
    }
}

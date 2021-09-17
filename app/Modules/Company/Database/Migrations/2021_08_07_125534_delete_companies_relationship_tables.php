<?php
/**
 *  app\Modules\Company\Database\Migrations\2021_08_07_125534_delete_companies_relationship_tables.php
 *
 * Date-Time: 8/7/2021
 * Time: 12:56 PM
 * @author Vito Makhatadze <vitomakhatadze@gmail.com>
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DeleteCompaniesRelationshipTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('company_activity_translations');
        Schema::dropIfExists('activity_translations');
        Schema::dropIfExists('companies_activities');
        Schema::dropIfExists('activity');
        Schema::dropIfExists('company_activities');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCompanyActivitiesSetCompanyActivityIdNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_activity_translations', function (Blueprint $table) {
            $table->bigInteger('company_activity_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_activity_translations', function (Blueprint $table) {
            $table->bigInteger('company_activity_id')->unsigned()->change();
        });
    }
}

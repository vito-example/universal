<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('team_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('team_id')->unsigned();
            $table->string('locale')->index();

            $table->string('name')->nullable();
            $table->longText('about')->nullable();
            $table->longText('position')->nullable();
            $table->json('seo_meta')->nullable();

            $table->unique(['team_id','locale']);
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}

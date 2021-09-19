<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->json('galleries_meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->json('seo_meta')->nullable();

            $table->unique(['project_id','locale']);
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}

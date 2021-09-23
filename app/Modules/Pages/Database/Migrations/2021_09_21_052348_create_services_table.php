<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->json('galleries_meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('service_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('service_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->json('seo_meta')->nullable();

            $table->unique(['service_id', 'locale']);
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}

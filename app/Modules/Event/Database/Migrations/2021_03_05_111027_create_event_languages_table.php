<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_languages', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('status')->default(1)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('event_language_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_language_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();

            $table->unique(['event_language_id','locale']);
            $table->foreign('event_language_id')->references('id')->on('event_languages')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_languages');
        Schema::dropIfExists('event_language_translations');
    }
}

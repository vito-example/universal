<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->dateTimeTz('start_date')->nullable();
            $table->json('organizers_meta')->nullable();
            $table->json('sponsors_meta')->nullable();
            $table->string('timezone')->nullable();
            $table->unsignedBigInteger('moderator_id')->index()->nullable();
            $table->unsignedBigInteger('event_language_id')->index()->nullable();
            $table->json('event_meta')->nullable();
            $table->unsignedInteger('status')->nullable();
            $table->json('speakers_meta')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('moderator_id')->references('id')->on('admins');
            $table->foreign('event_language_id')->references('id')->on('event_languages');
        });

        Schema::create('event_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->longText('description')->nullable();

            $table->unique(['event_id','locale']);
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_translations');
    }
}

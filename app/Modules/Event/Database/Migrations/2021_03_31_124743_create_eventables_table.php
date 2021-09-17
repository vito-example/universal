<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->index()->nullable();
            $table->string('eventable_type')->nullable();
            $table->unsignedBigInteger('eventable_id')->nullable();
            $table->json('info_meta')->nullable();
            $table->string('type')->index()->nullable();
            $table->index(['eventable_type', 'eventable_id'], 'eventable_connections');
            $table->timestamps();

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
        Schema::dropIfExists('eventables');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('activity_verify_id')->nullable();
            $table->string('personal_number')->nullable()->unique();
            $table->string('passport_number')->nullable()->unique();
            $table->string('phone_number')->nullable()->index()->unique();
            $table->boolean('terms')->nullable();
            $table->boolean('advertisement')->nullable();
            $table->unsignedBigInteger('activity_id')->index()->nullable();
            $table->unsignedBigInteger('citizenship_id')->index()->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('password');
            $table->text('profile_photo_path')->nullable();
            $table->unsignedTinyInteger('status')->default(0)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

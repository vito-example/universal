<?php

use App\Modules\Customer\Models\Citizenship;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitizenshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citizenship', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->default(0)->nullable();
            $table->string('country_code',30)->default(Citizenship::COUNTRY_CODE_GE)->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('citizenship_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('citizenship_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();

            $table->unique(['citizenship_id','locale']);
            $table->foreign('citizenship_id')->references('id')->on('citizenship')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citizenship');
        Schema::dropIfExists('citizenship_translations');
    }
}

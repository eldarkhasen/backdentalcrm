<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')
                ->nullable(false);

            // GREENWICH FAULT
            $table->double('timezone')
                ->default(0);

            $table->unsignedBigInteger('country_id')
                ->nullable(true);
            $table->foreign('country_id')
                ->on('countries')
                ->references('id')
                ->onDelete("RESTRICT");

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
        Schema::dropIfExists('cities');
    }
}

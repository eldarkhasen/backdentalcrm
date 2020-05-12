<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('surname');
            $table->string('patronymic')->nullable();
            $table->string('phone')->unique();
            $table->string("birth_date");
            $table->string('gender');
            $table->string('id_card')->nullable()->unique();
            $table->string('id_number')->nullable()->unique();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('workplace')->nullable();
            $table->string('position')->nullable();
            $table->integer('discount')->nullable()->default(0);
            $table->string('photoname')->nullable();
            $table->string('mime')->nullable();
            $table->string('original_photoname')->nullable();
            $table->text('special_conditions')->nullable();
            $table->text('anamnesis_vitae')->nullable();
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
        Schema::dropIfExists('patients');
    }
}

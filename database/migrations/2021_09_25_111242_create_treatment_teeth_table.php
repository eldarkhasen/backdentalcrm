<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentTeethTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatment_teeth', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treatment_id')
                ->references('id')
                ->on('treatments')
                ->cascadeOnDelete();
            $table->integer('tooth_number');
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
        Schema::dropIfExists('treatment_teeth');
    }
}

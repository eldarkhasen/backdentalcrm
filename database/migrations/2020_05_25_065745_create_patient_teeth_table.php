<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientTeethTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_teeth', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id')
                ->nullable(false);
            $table->foreign('patient_id')
                ->on('patients')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('initial_inspection_id')
                ->nullable(true);
            $table->foreign('initial_inspection_id')
                ->on('initial_inspections')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('treatment_id')
                ->nullable(true);
            $table->foreign('treatment_id')
                ->on('treatments')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('diagnosis_id')
                ->nullable(true);
            $table->foreign('diagnosis_id')
                ->on('diagnoses')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedInteger('tooth_number')
                ->nullable(false);

            $table->text('comments')
                ->nullable(false);

            $table->boolean('is_finished')
                ->default(false);

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
        Schema::dropIfExists('patient_teeth');
    }
}

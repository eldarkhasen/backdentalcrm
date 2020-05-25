<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('appointment_id')
                ->nullable(false);
            $table->foreign('appointment_id')
                ->on('appointments')
                ->references('id')
                ->onDelete('RESTRICT');


            $table->unsignedBigInteger('diagnosis_id')
                ->nullable(false);
            $table->foreign('diagnosis_id')
                ->on('diagnoses')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('diagnosis_type_id')
                ->nullable(true);
            $table->foreign('diagnosis_type_id')
                ->on('diagnosis_types')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedInteger('tooth_number')
                ->nullable(false)
                ->default(0);
            $table->text('patient_problems')
                ->nullable();
            $table->text('xray_data')
                ->nullable();
            $table->text('work_done')
                ->nullable();
            $table->text('recommendations')
                ->nullable();
            $table->text('comments')
                ->nullable();
            $table->text('treatment_plan')
                ->nullable();
            $table->text('objective_data')
                ->nullable();
            $table->boolean('is_finished')
                ->default(false);

            $table->unsignedBigInteger('final_diagnosis_id')
                ->nullable();
            $table->foreign('final_diagnosis_id')
                ->on('diagnoses')
                ->references('id')
                ->onDelete('RESTRICT');
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
        Schema::dropIfExists('treatments');
    }
}

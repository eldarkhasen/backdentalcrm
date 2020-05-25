<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->string('title')
                ->nullable(false);
            $table->timestamp('start_date')
                ->nullable()->default(null);
            $table->timestamp('end_date')
                ->nullable()->default(null);
            $table->double('price')
                ->default(0);
            $table->enum('status', ['pending', 'success', 'client_miss']);
            $table->string('color')
                ->nullable(false);
            $table->unsignedBigInteger('employee_id')
                ->nullable(false);
            $table->foreign('employee_id')
                ->on('employees')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('patient_id')
                ->nullable(false);
            $table->foreign('patient_id')
                ->on('patients')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('treatment_course_id')
                ->nullable(false);
            $table->foreign('treatment_course_id')
                ->on('treatment_courses')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->boolean('is_first_visit')
                ->default(true);

            $table->softDeletes();
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
        Schema::dropIfExists('appointments');
    }
}

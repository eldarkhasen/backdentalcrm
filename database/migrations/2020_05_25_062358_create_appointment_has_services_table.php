<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentHasServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_has_services', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id')
                ->nullable(false);
            $table->foreign('patient_id')
                ->on('patients')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('service_id')
                ->nullable(false);
            $table->foreign('service_id')
                ->on('services')
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
        Schema::dropIfExists('appointment_has_services');
    }
}

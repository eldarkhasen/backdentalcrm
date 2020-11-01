<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPatientIdFromAppointmentHasServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_has_services', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn('patient_id');
            $table->unsignedBigInteger('appointment_id')
                ->nullable(false);
            $table->foreign('appointment_id')
                ->on('appointments')
                ->references('id')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_has_services', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropColumn('appointment_id');
            $table->unsignedBigInteger('patient_id')
                ->nullable(false);
            $table->foreign('patient_id')
                ->on('patients')
                ->references('id')->onDelete('CASCADE');
        });
    }
}

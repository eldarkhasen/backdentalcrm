<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_patients', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('organization_id')
                ->nullable(false);
            $table->foreign('organization_id')
                ->on('organizations')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('patient_id')
                ->nullable(false);
            $table->foreign('patient_id')
                ->on('patients')
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
        Schema::dropIfExists('organization_patients');
    }
}

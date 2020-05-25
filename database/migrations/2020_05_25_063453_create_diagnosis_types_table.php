<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagnosisTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis_types', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('diagnosis_id')
                ->nullable(false);
            $table->foreign('diagnosis_id')
                ->on('diagnoses')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('organization_id')
                ->nullable(true);
            $table->foreign('organization_id')
                ->on('organizations')
                ->references('id')
                ->onDelete('RESTRICT');

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
        Schema::dropIfExists('diagnosis_types');
    }
}

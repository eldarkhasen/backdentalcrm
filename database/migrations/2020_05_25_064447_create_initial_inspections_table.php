<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitialInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initial_inspections', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('appointment_id')
                ->nullable(false);
            $table->foreign('appointment_id')
                ->on('appointments')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->text('anamnesis_vitae')
                ->nullable(false);
            $table->text('anamnesis_morbi')
                ->nullable(false);
            $table->text('visual_inspection')
                ->nullable(false);
            $table->text('bite')
                ->nullable(false);
            $table->text('mucosal_conditions')
                ->nullable(false);

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
        Schema::dropIfExists('initial_inspections');
    }
}

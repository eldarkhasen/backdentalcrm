<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashFlowOperations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flow_operations', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('from_cash_box_id')
                ->index()->nullable();
            $table->foreign('from_cash_box_id')
                ->on('cash_boxes')
                ->references('id');

            $table->unsignedInteger('to_cash_box_id')
                ->index()->nullable();
            $table->foreign('to_cash_box_id')
                ->on('cash_boxes')
                ->references('id');

            $table->unsignedInteger('type_id')
                ->index();
            $table->foreign('type_id')
                ->on('cash_flow_operation_types')
                ->references('id');

            $table->unsignedBigInteger('appointment_id')
                ->index()
                ->nullable();
            $table->foreign('appointment_id')
                ->on('appointments')
                ->references('id');

            $table->integer('amount');

            $table->string('comments')->nullable();

            $table->boolean('committed')->default(false);

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
        Schema::dropIfExists('cash_flow_operations');
    }
}

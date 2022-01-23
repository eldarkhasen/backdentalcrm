<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmployeesHasPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees_has_positions', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropForeign(['employee_id']);
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees_has_positions', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropForeign(['employee_id']);
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('employee_id')->references('id')->on('employees');

        });
    }
}

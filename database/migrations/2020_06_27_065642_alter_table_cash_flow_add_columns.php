<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCashFlowAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_flow_operations', function (Blueprint $table) {
            $table->date('cash_flow_date');
            $table->unsignedBigInteger('user_created_id')
                ->nullable(true);
            $table->foreign('user_created_id')
                ->on('employees')
                ->references('id')
                ->onDelete('RESTRICT');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_flow_operations', function (Blueprint $table) {
            $table->dropColumn('cash_flow_date');
            $table->dropForeign(['user_created_id']);
            $table->dropColumn('user_created_id');

        });
    }
}

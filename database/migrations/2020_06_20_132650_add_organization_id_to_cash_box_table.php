<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrganizationIdToCashBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_boxes', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')
                ->index();
            $table->foreign('organization_id')
                ->on('organizations')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cash_boxes', function (Blueprint $table) {
            $table->dropForeign('cash_boxes_organization_id_foreign');
            $table->dropIndex('cash_boxes_organization_id_index');
            $table->dropColumn('organization_id');
        });
    }
}

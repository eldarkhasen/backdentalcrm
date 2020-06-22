<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialRestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_rests', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('material_id')->index();
            $table->foreign('material_id')
                ->on('materials')
                ->references('id');

            $table->unsignedBigInteger('organization_id')->index();
            $table->foreign('organization_id')
                ->on('organizations')
                ->references('id');

            $table->bigInteger('count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('material_rests');
    }
}

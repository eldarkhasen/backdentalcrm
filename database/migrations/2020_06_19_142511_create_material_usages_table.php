<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_usages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('material_id')->index();
            $table->foreign('material_id')
                ->on('materials')
                ->references('id')
                ->onDelete('cascade');
            $table->unsignedBigInteger('employee_id')->index();
            $table->foreign('employee_id')
                ->on('employees')
                ->references('id')
                ->onDelete('cascade');
            $table->integer('quantity');
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('material_usages');
    }
}

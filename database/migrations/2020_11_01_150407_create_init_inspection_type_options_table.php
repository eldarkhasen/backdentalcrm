<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitInspectionTypeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('init_inspection_type_options', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->unsignedBigInteger('init_inspection_type_id')->index();
            $table->foreign('init_inspection_type_id')
                ->on('init_inspection_types')
                ->references('id')
                ->onDelete('cascade');
            $table->boolean('is_custom')->default(false);
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
        Schema::dropIfExists('init_inspection_type_options');
    }
}

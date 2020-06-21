<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMaterialUsagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('material_usages', function (Blueprint $table) {
           $table->dropForeign('material_usages_material_id_foreign');
           $table->dropIndex('material_usages_material_id_index');

           $table->renameColumn('material_id', 'material_rest_id');

           $table->index('material_rest_id');
           $table->foreign('material_rest_id')
               ->on('material_rests')
               ->references('id');

           $table->boolean('committed')->default(false);
           $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('material_usages', function (Blueprint $table) {
            $table->dropForeign('material_usages_material_rest_id_foreign');
            $table->dropIndex('material_usages_material_rest_id_index');

            $table->renameColumn('material_rest_id', 'material_id');

            $table->index('material_id');
            $table->foreign('material_id')
                ->on('materials')
                ->references('id');

            $table->dropColumn('committed');
            $table->dropColumn('deleted_at');
        });
    }
}

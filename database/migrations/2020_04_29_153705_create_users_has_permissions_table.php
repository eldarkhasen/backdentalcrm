<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersHasPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
//        Schema::create('users_has_permissions', function (Blueprint $table) use ($tableNames, $columnNames) {
//
//            $table->unsignedInteger('permission_id');
//            $table->string('model_type');
//            $table->unsignedBigInteger($columnNames['model_morph_key']);
//            $table->index([$columnNames['model_morph_key'], 'model_type', ]);
//
//            $table->foreign('permission_id')
//                ->references('id')
//                ->on($tableNames['permissions'])
//                ->onDelete('cascade');
//
//            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
//                'model_has_permissions_permission_model_type_primary');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_permissions');
    }
}

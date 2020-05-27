<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableOrganizationsDropColumnCountryIdAddColumnCityId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');

            $table->unsignedBigInteger('city_id')
                ->nullable(true);
            $table->foreign('city_id')
                ->on('cities')
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
        Schema::table('organizations', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');

            $table->unsignedBigInteger('country_id')
                ->nullable(true);
            $table->foreign('country_id')
                ->on('countries')
                ->references('id')
                ->onDelete('RESTRICT');
        });
    }
}

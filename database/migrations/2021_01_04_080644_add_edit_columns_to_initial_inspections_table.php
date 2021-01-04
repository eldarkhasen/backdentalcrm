<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditColumnsToInitialInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('initial_inspections', function (Blueprint $table) {
            $table->dropColumn('anamnesis_vitae');
            $table->dropColumn('anamnesis_morbi');
            $table->dropColumn('visual_inspection');
            $table->dropColumn('bite');
            $table->dropColumn('mucosal_conditions');
            $table->foreignId('inspection_type_id')
                ->constrained('init_inspection_types', 'id');
            $table->foreignId('inspection_option_id')
                ->constrained('init_inspection_type_options', 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('initial_inspections', function (Blueprint $table) {
            $table->text('anamnesis_vitae')
                ->nullable(false);
            $table->text('anamnesis_morbi')
                ->nullable(false);
            $table->text('visual_inspection')
                ->nullable(false);
            $table->text('bite')
                ->nullable(false);
            $table->text('mucosal_conditions')
                ->nullable(false);
            $table->dropColumn('inspection_type_id');
            $table->dropColumn('init_inspection_type_options');
        });
    }
}

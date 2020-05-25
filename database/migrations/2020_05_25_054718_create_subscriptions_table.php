<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start_date')
                ->nullable(false);
            $table->timestamp('end_date')
                ->nullable(true);
            $table->double('actual_price')
                ->nullable(false);

            $table->unsignedBigInteger('subscription_type_id')
                ->nullable(false);
            $table->foreign('subscription_type_id')
                ->on('subscription_types')
                ->references('id')
                ->onDelete('RESTRICT');

            $table->unsignedBigInteger('organization_id')
                ->nullable(false);
            $table->foreign('organization_id')
                ->on('organizations')
                ->references('id')
                ->onDelete('RESTRICT');


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
        Schema::dropIfExists('subscriptions');
    }
}

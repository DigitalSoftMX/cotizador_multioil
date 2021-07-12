<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('terminal_id');
            $table->double('regular')->default(0);
            $table->double('premium')->default(0);
            $table->double('diesel')->default(0);
            $table->double('regular_sf')->default(0);
            $table->double('premium_sf')->default(0);
            $table->double('diesel_sf')->default(0);
            $table->unsignedBigInteger('fee_id');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('terminal_id')->references('id')->on('terminals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('fee_id')->references('id')->on('fees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}

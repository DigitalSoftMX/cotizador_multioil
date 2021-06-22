<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('terminal_id');
            $table->integer('liters_r')->default(0);
            $table->integer('liters_p')->default(0);
            $table->integer('liters_d')->default(0);
            $table->double('total_r')->default(0);
            $table->double('total_p')->default(0);
            $table->double('total_d')->default(0);
            $table->double('total')->default(0);
            $table->timestamp('date')->nullable();
            $table->integer('freight');
            $table->integer('secure')->default(0);
            $table->unsignedBigInteger('status_id')->default(1);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('terminal_id')->references('id')->on('terminals')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('status_id')->references('id')->on('status')
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
        Schema::dropIfExists('orders');
    }
}

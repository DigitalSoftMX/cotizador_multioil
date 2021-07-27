<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('terminal_id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('base_id')->nullable();
            $table->double('regular_fit');
            $table->double('premium_fit');
            $table->double('diesel_fit');
            $table->integer('active')->default(1);
            $table->timestamps();

            $table->foreign('terminal_id')->references('id')->on('terminals')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('base_id')->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fees');
    }
}

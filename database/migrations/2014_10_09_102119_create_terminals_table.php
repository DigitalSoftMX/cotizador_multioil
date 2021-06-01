<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('business_name');
            $table->string('rfc');
            $table->string('name');
            $table->integer('status');
            $table->string('postcode');
            $table->string('kind_road');
            $table->string('name_road');
            $table->string('n_outsice');
            $table->string('n_inside');
            $table->string('settlement')->nullable();
            $table->string('location')->nullable();
            $table->string('town')->nullable();
            $table->string('state')->nullable();
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
        Schema::dropIfExists('terminals');
    }
}

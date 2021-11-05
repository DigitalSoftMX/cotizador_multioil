<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('terminal_id');
            $table->unsignedBigInteger('company_id');
            $table->string('nflete');
            $table->string('nseguro');
            $table->string('regularL');
            $table->string('regularMa');
            $table->string('regularMi');
            $table->string('regularJ');
            $table->string('regularV');
            $table->string('regularS');
            $table->string('premiumL');
            $table->string('premiumMa');
            $table->string('premiumMi');
            $table->string('premiumJ');
            $table->string('premiumV');
            $table->string('premiumS');
            $table->string('dieselL');
            $table->string('dieselMa');
            $table->string('dieselMi');
            $table->string('dieselJ');
            $table->string('dieselV');
            $table->string('dieselS');
            $table->string('monday');
            $table->string('tuesday');
            $table->string('wednesday');
            $table->string('thursday');
            $table->string('friday');
            $table->string('saturday');
            $table->string('totalR');
            $table->string('totalP');
            $table->string('totalD');
            $table->string('grantotal');
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
        Schema::dropIfExists('pedidos');
    }
}

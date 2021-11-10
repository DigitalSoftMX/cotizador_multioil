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
            $table->integer('freight');
            $table->string('name_freight')->nullable();
            $table->integer('secure')->default(0);
            $table->double('price');
            $table->double('sale_price')->nullable();
            $table->double('liters')->default(0);
            $table->string('product');
            $table->double('total')->default(0);
            $table->timestamp('date')->nullable();
            $table->timestamp('dispatched')->nullable();
            $table->double('dispatched_liters')->nullable();
            $table->double('bol_load')->nullable();
            $table->double('root_liters')->nullable();
            $table->double('invoice')->nullable();
            $table->string('invoicefolio')->nullable();
            $table->string('CFDI')->nullable();
            $table->string('pdf')->nullable();
            $table->string('xml')->nullable();
            $table->double('commission')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double('commission_two')->nullable();
            $table->unsignedBigInteger('middleman_id')->nullable();
            $table->double('invoicepayment')->nullable();
            $table->string('paymentfolio')->nullable();
            $table->string('invoicecfdi')->nullable();
            $table->string('invoicepdf')->nullable();
            $table->string('invoicexml')->nullable();
            $table->string('shipper')->nullable();
            $table->string('number_shipper')->nullable();
            $table->double('invoice_shipper')->nullable();
            $table->string('shipperpdf')->nullable();
            $table->string('shipperxml')->nullable();
            $table->string('shipperfolio')->nullable();
            $table->string('credit')->nullable();
            $table->double('amount')->nullable();
            $table->string('creditpdf')->nullable();
            $table->string('creditxml')->nullable();
            $table->string('reason')->nullable();
            $table->string('type')->nullable();
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

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('middleman_id')->references('id')->on('users')
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

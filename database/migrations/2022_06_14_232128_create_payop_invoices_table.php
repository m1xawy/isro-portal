<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayOpInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payop_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('invoice_id')->nullable();
            $table->json('data')->nullable();
            $table->string('payload');
            $table->string('name');
            $table->double('price', 5);
            $table->integer('silk');
            $table->enum('state', ['pending', 'canceled', 'declined', 'paid']);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payop_invoices');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_dishes', function (Blueprint $table) {
            $table->foreignId('order_nummer')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreignId('dish_id')->references('id')->on('dishes')->cascadeOnDelete();
            $table->integer("amount");
            $table->text("notation")->nullable();
            $table->decimal("price", 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_dishes');
    }
};

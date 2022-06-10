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
        Schema::create('dishes_history_of_discounts', function (Blueprint $table) {
            $table->foreignId('history_of_discounts_id')->references('id')->on('history_of_discounts')->cascadeOnDelete();
            $table->foreignId('dishes_id')->references('id')->on('dishes')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dishes_history_of_discounts');
    }
};

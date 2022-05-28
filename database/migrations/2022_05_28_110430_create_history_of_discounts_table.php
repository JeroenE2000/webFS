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
        Schema::create('history_of_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dishes_id')->references('id')->on('dishes')->cascadeOnDelete();
            $table->dateTime("start_time");
            $table->dateTime("end_time");
            $table->decimal("discount", 2, 2);
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
        Schema::dropIfExists('history_of_discounts');
    }
};

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
        Schema::create('table_users', function (Blueprint $table) {
            $table->foreignId('table_id')->references('id')->on('tables')->cascadeOnDelete();
            $table->foreignId('users_id')->references('id')->on('users')->cascadeOnDelete();
            $table->datetime("start_time");
            $table->datetime("end_time")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_users');
    }
};

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
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->string('categorie_id');
            $table->foreign('categorie_id')->references('name')->on('categories')->cascadeOnDelete();
            $table->integer("dishnumber")->nullable();
            $table->string("dish_addition")->nullable();
            $table->string("name");
            $table->decimal("price", 10, 2);
            $table->text("description")->nullable();
            $table->integer("spicness_scale")->nullable();
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
        Schema::dropIfExists('dishes');
    }
};

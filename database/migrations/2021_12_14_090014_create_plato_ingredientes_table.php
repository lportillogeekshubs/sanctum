<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatoIngredientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plato_ingredientes', function (Blueprint $table) {
            $table->unsignedBigInteger('id_plato');
            $table->unsignedBigInteger('id_ingrediente');
            $table->integer('cantidad');
            $table->timestamps();
            $table->foreign('id_plato')->references('id')->on('platos')->onDelete('cascade');
            $table->foreign('id_ingrediente')->references('id')->on('ingredientes')->onDelete('cascade');
            $table->unique(['id_plato', 'id_ingrediente']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plato_ingredientes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despacho_productos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('producto_id');
            $table->bigInteger('orden_despacho_id');
            $table->string('unidad_medida');
            $table->integer('cantidad_ordenada');
            $table->integer('cantidad_despachada');
            $table->integer('cantidad_entregada');
            $table->timestamps();

            $table
                ->foreign('producto_id')
                ->references('id')
                ->on('productos')
                ->onDelete('cascade');

            $table
                ->foreign('orden_despacho_id')
                ->references('id')
                ->on('ordenes_despacho')
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
        Schema::dropIfExists('despacho_productos');
    }
};
